<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Customer;
use App\Launch;
use App\Order;
use App\OrderDetail;
use App\Product;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LaunchController extends Controller
{
    public function create(){
        $cart_products = Cart::all();
        $cart = Cart::all();
        $drinks = Product::all();

        $Launch_products = Launch::all();
        $Launch = Launch::all();

        $customers = Customer::all();

        return view('admin.pos.launch', compact('cart_products', 'cart', 'drinks', 'customers'));
    }

    public function cart_store(Request $request)
    {
        $inputs = $request->except('_token');
        $rules = [
          'product_id' => 'required | integer',
          'name' => 'required',
          'cartons' => 'required',
          'price' => 'required',
        ];

        $validator = Validator::make($inputs, $rules);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $cart = new Cart();
        $cart->product_id = $request->input('product_id');
        $cart->name = $request->input('name');
        $cart->cartons = $request->input('cartons');
        $cart->quantity = $cart->cartons * 12;
        $cart->price = $request->input('price');
        $cart->total = $cart->quantity * $cart->price;
        // $cart->exchange = $request->input('exchange') ? '1' : '0';
        $cart->save();

        // $add = Cart::add(['id' => $id, 'name' => $name, 'qty' => $qty, 'price' => $price, 'weight' => 1, 'exchange' => $exchange ]);

        Toastr::success('Drink successfully added to cart', 'Success');
        return redirect()->back();
    }

    public function cart_update(Request $request, $id)
    {
        $cart = Cart::find($id);
        $cart->cartons = $request->input('cartons');
        $cart->quantity = $cart->cartons * 12;
        $cart->total = $cart->quantity * $cart->price;
        $cart->save();

        Toastr::success('Cart Updated Successfully', 'Success');
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
        $cart_products = Cart::all();
        $sub_total = str_replace(',', '', Cart::sum('total'));
        $tax = str_replace(',', '', 0);
        $c_total = str_replace(',', '', Cart::sum('total'));

        foreach ($cart_products as $drink) {
            $product = Product::find($drink->product_id);
            $product->stock -= $drink->quantity;
            $product->save();

            $launch = new Launch();
            $launch->product_id = $drink->product_id;
            $launch->name = $drink->name;
            $launch->cartons = $drink->cartons;
            $launch->quantity = $drink->quantity;
            $launch->price = $drink->price;
            $launch->total = $drink->total;
            $launch->save();
        }

        $due = $c_total - $c_total;

        $order = new Order();
        $order->customer_id =  $customer->id;
        $order->customer_name = $customer->name;
        $order->customer_phone = $customer->phone;
        $order->payment_status = 'launching';
        $order->pay = $c_total;
        $order->due = $due;
        $order->order_date = date('Y-m-d');
        // $order->order_status = $order->payment_status == 'cash' ? 'confirmed' : 'pending';
        $order->order_status = 'confirmed';
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