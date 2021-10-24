<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Customer;
use App\Exchange;
use App\ExchangeIn;
use App\ExchangeOut;
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
          'drink_id' => 'required | integer',
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
        $exchange->drink_id = $request->input('drink_id');
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
        $exchange = Exchange::find($id);
        $exchange->quantity = $request->input('quantity');
        $exchange->total = $exchange->quantity * $exchange->price;
        $exchange->save();

        Toastr::success('Exchange Updated Successfully', 'Success');
        return redirect()->back();
    }

    public function final_invoice(Request $request)
    {
        $inputs = $request->except('_token');
        $rules = [
        //   'payment_status' => 'required',
          'customer_id' => 'integer',
        ];
        $customMessages = [
            // 'payment_status.required' => 'Select a Payment method first!.',
        ];

        $validator = Validator::make($inputs, $rules, $customMessages);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $man_customer = new \stdClass();
        $man_customer->id = 100000000;
        $man_customer->name = $request->input('name');
        $man_customer->phone = $request->input('phone');
        // dd($man_customer);

        $customer_id = $request->input('customer_id');
        $customer = $customer_id ? Customer::findOrFail($customer_id) : $man_customer;
        // dd($customer);

        // cart stuffs
        $exchange_out = Cart::all();
        $sub_total = str_replace(',', '', Cart::sum('total'));
        $tax = str_replace(',', '', 0);
        $c_total = str_replace(',', '', Cart::sum('total'));

        foreach ($exchange_out as $drink) {
            $product = Product::find($drink->drink_id);
            $product->stock -= $drink->quantity;
            $product->save();

            $x_out = new ExchangeOut();
            $x_out->drink_id = $drink->drink_id;
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
            $product = Product::find($drink->drink_id);
            $product->stock += $drink->quantity;
            $product->save();

            $x_in = new ExchangeIn();
            $x_in->drink_id = $drink->drink_id;
            $x_in->name = $drink->name;
            $x_in->quantity = $drink->quantity;
            $x_in->price = $drink->price;
            $x_in->total = $drink->total;
            $x_in->save();
        }

        $due = $c_total - $x_total;

        $order = new Order();
        $order->customer_id =  $customer->id;
        $order->customer_name = $customer->name;
        $order->customer_phone = $customer->phone;
        $order->payment_status = 'exchange';
        $order->pay = $x_total;
        $order->due = $due;
        $order->order_date = date('Y-m-d');
        $order->order_status = $order->payment_status == 'cash' ? 'confirmed' : 'pending';
        $order->total_products = Cart::sum('quantity');
        $order->sub_total = $sub_total;
        $order->owing = $order->due > 0 ? true : false;
        $order->to_balance = $order->due < 0 ? true : false;
        $order->vat = $tax;
        $order->total = $c_total;
        $order->save();

        $order_id = $order->id;
        $contents = Cart::all();
        // dd($order);

        foreach ($contents as $content)
        {
            $order_detail = new OrderDetail();
            $order_detail->order_id = $order_id;
            $order_detail->drink_id = $content->id;
            $order_detail->quantity = $content->quantity;
            $order_detail->unit_cost = $content->price;
            $order_detail->total = $content->total;
            $order_detail->save();
        }

        Cart::truncate();
        Exchange::truncate();

        Toastr::success('Invoice created successfully', 'Success');
        return redirect()->route('admin.order.pending');
    }
}
