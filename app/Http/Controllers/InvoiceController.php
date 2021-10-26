<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Customer;
use App\Order;
use \stdClass;
use App\OrderDetail;
use App\Product;
use App\Setting;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    public function create(Request $request)
    {
        $inputs = $request->except('_token');
        $rules = [
          'customer_id' => 'integer',
        ];
        $customMessages = [
            // 'customer_id.required' => 'Select a Customer first!.',
            'customer_id.integer' => 'Invalid Customer!.'
        ];
        $validator = Validator::make($inputs, $rules, $customMessages);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (!isset($man_customer)){
            $man_customer = new \stdClass();
            $man_customer->id = 100000000;
            $man_customer->name = $request->input('name');
            $man_customer->phone = $request->input('phone');
        }
        // dd($man_customer);

        $customer_id = $request->input('customer_id');
        $customer = $customer_id ? Customer::findOrFail($customer_id) : $man_customer;
        $contents = Cart::all();
        $company = Setting::latest()->first();

        $drinks = Product::all();
        return view('admin.invoice', compact('customer', 'contents', 'company', 'drinks'));
    }

    public function print($customer_id)
    {
        $customer = Customer::findOrFail($customer_id);
        $contents = Cart::content();
        $company = Setting::latest()->first();
        return view('admin.print', compact('customer', 'contents', 'company'));
    }

    public function order_print($order_id)
    {
        $order = Order::where('id', $order_id)->first();
        //return $order;
        $order_details = OrderDetail::with('product')->where('order_id', $order_id)->get();
        //return $order_details;
        $company = Setting::latest()->first();
        return view('admin.order.print', compact('order_details', 'order', 'company'));
    }


    public function final_invoice(Request $request)
    {
        $inputs = $request->except('_token');
        $rules = [
          'payment_status' => 'required',
          'customer_id' => 'integer',
        ];
        $customMessages = [
            'payment_status.required' => 'Select a Payment method first!.',
        ];

        $validator = Validator::make($inputs, $rules, $customMessages);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $sub_total = str_replace(',', '', Cart::sum('total'));
        $tax = str_replace(',', '', 0);
        $total = str_replace(',', '', Cart::sum('total'));

        $pay = $request->input('payment_status') == 'cash' ? $request->input('cash') : $request->input('pay');
        $debt = $total - $pay;

        $order = new Order();
        $order->customer_id =  $request->input('customer_id');
        $order->customer_name = $request->input('customer_name');
        $order->customer_phone = $request->input('customer_phone');
        $order->payment_status = $request->input('payment_status');
        $order->pay = $pay;
        $order->debt = $debt;
        $order->order_date = date('Y-m-d');
        $order->order_status = $order->payment_status == 'cash' ? 'confirmed' : 'pending';
        $order->total_products = Cart::sum('quantity');
        $order->sub_total = $sub_total;
        $order->owing = $order->debt > 0 ? true : false;
        $order->to_balance = $order->debt < 0 ? true : false;
        $order->vat = $tax;
        $order->total = $total;
        // dd($order);
        $order->save();

        $order_id = $order->id;
        $contents = Cart::all();

        foreach ($contents as $content)
        {
            $product = Product::find($content->product_id);
            $product->stock -= $content->quantity;
            $product->save();

            // cummulating the total cost for each product in the order
            $order = Order::find($order_id);
            $order->total_cost += $content->total_cost;
            $order->save();

            $order_detail = new OrderDetail();
            $order_detail->order_id = $order_id;
            $order_detail->product_id = $content->id;
            $order_detail->quantity = $content->quantity;
            $order_detail->unit_cost = $content->price;
            $order_detail->total = $content->total;
            $order_detail->save();
        }

        Cart::truncate();

        Toastr::success('Invoice created successfully', 'Success');
        return redirect()->route('admin.order.pending');
    }
}
