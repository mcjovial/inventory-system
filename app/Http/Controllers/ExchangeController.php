<?php

namespace App\Http\Controllers;

use Auth;
use App\Cart;
use App\Customer;
use App\Exchange;
use App\Exchangein;
use App\Exchangeout;
use App\Order;
use App\OrderDetail;
use App\Product;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExchangeController extends Controller
{
    public function create(){
        $cart_products = Cart::all();
        $cart = Cart::all();
        $drinks = Product::all();

        $exchange_products = Exchange::all();
        $exchange = Exchange::all();

        $customers = Customer::all();

        return view('admin.pos.exchange', compact('cart_products', 'cart', 'drinks', 'exchange_products', 'exchange', 'customers'));
    }

    public function store(Request $request)
    {
        $inputs = $request->except('_token');
        $rules = [
          'product_id' => 'required | integer',
          'name' => 'required',
          'quantity' => 'required',
          'price' => 'required',
        ];

        $validator = Validator::make($inputs, $rules);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $exchange = new Exchange();
        $exchange->product_id = $request->input('product_id');
        $exchange->name = $request->input('name');
        $exchange->quantity = $request->input('quantity');
        $exchange->price = $request->input('price');
        $exchange->total = $exchange->quantity * $exchange->price;
        $exchange->save();

        // $add = Cart::add(['id' => $id, 'name' => $name, 'qty' => $qty, 'price' => $price, 'weight' => 1, 'exchange' => $exchange ]);

        Toastr::success('Drink successfully added to exchange', 'Success');
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        dd($request);
        $exchange = Exchange::find($id);
        $exchange->quantity = $request->input('quantity');
        $exchange->total = $exchange->quantity * $exchange->price;
        $exchange->save();

        Toastr::success('Exchange Updated Successfully', 'Success');
        return redirect()->back();
    }

    public function final_invoice(Request $request)
    {
        // dd($request);
        $inputs = $request->except('_token');
        $rules = [
        //   'payment_status' => 'required',
          'name' => 'required',
        ];
        $customMessages = [
            // 'payment_status.required' => 'Select a Payment method first!.',
            'name.required' => 'Please select  a user!'
        ];

        $validator = Validator::make($inputs, $rules, $customMessages);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        function split_name($name) {
            $name = trim($name);
            $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
            $first_name = trim( preg_replace('#'.preg_quote($last_name,'#').'#', '', $name ) );
            return array($first_name, $last_name);
        }

        $customer_name = strtolower($request->input('name'));
        $customer = Customer::where('full_name', $customer_name)->first();
        // dd($customer);

        // cart stuffs
        $exchange_out = Cart::all();
        $sub_total = str_replace(',', '', Cart::sum('total'));
        $tax = str_replace(',', '', 0);
        $c_total = str_replace(',', '', Cart::sum('total'));

        foreach ($exchange_out as $drink) {
            $product = Product::find($drink->product_id);
            $product->stock -= $drink->quantity;
            $product->save();

            $x_out = new ExchangeOut();
            $x_out->product_id = $drink->product_id;
            $x_out->name = $drink->name;
            $x_out->quantity = $drink->quantity;
            $x_out->price = $drink->price;
            $x_out->total = $drink->total;
            $x_out->save();
        }

        // exchange stuffs
        $exchange_in = Exchange::all();
        $sub_total = str_replace(',', '', Exchange::sum('total'));
        $x_total = str_replace(',', '', Exchange::sum('total'));

        foreach ($exchange_in as $drink) {
            $product = Product::find($drink->product_id);
            $product->stock += $drink->quantity;
            $product->save();

            $x_in = new ExchangeIn();
            $x_in->product_id = $drink->product_id;
            $x_in->name = $drink->name;
            $x_in->quantity = $drink->quantity;
            $x_in->price = $drink->price;
            $x_in->total = $drink->total;
            $x_in->save();
        }

        $debt = $c_total - $x_total;

        $order = new Order();
        $order->customer_id =  $customer->id;
        $order->seller = Auth::user()->name;
        $order->customer_name = $customer->full_name;
        $order->customer_phone = $customer->phone;
        $order->payment_status = 'exchange';
        $order->pay = $x_total;
        $order->debt = $debt;
        $order->order_date = date('Y-m-d');
        $order->order_status = 'confirmed';
        $order->total_products = Cart::sum('quantity');
        $order->sub_total = $sub_total;
        $order->owing = $order->debt > 0 ? true : false;
        $order->to_balance = $order->debt < 0 ? true : false;
        $order->vat = $tax;
        $order->total = $c_total;
        // dd($order);
        $order->save();

        $order_id = $order->id;
        $contents = Cart::all();

        foreach ($contents as $content)
        {
            $order_detail = new OrderDetail();
            $order_detail->order_id = $order_id;
            $order_detail->product_id = $content->id;
            $order_detail->quantity = $content->quantity;
            $order_detail->unit_cost = $content->price;
            $order_detail->total = $content->total;
            $order_detail->save();
        }

        Cart::truncate();
        Exchange::truncate();

        Toastr::success('Invoice created successfully', 'Success');
        return redirect()->route('admin.order.approved');
    }
}
