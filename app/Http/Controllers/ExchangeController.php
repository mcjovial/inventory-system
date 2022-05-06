<?php

namespace App\Http\Controllers;

use Auth;
use App\Cart;
use App\Customer;
use App\Exchange;
use App\Exchangein;
use App\Exchangeout;
use App\exchangeInCart;
use App\exchangeOutCart;
use App\Order;
use App\OrderDetail;
use App\Product;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExchangeController extends Controller
{
    public function create($id){
        // $cart_products = Cart::all();

        $order = Order::find($id);
        $cart_in = exchangeInCart::all();
        $cart_out = exchangeOutCart::all();
        $drinks = Product::all();

        $customers = Customer::all();

        return view('admin.pos.exchange', compact('order', 'cart_in', 'cart_out', 'drinks', 'customers'));
    }

    public function exchange_in_cart_store(Request $request){
        // dd($request);
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

        $cart = new exchangeInCart();
        $cart->product_id = $request->input('product_id');
        $product = Product::find($cart->product_id);

        if($product->stock < 1 || $product->stock < $request->input('quantity')){
            Toastr::error('No stock!! Please seek supply.', 'Error');
            return redirect()->back();
        }

        $cart->name = $request->input('name');
        $cart->quantity = $request->input('quantity');
        $cart->price = $request->input('price');
        $cart->total = $cart->quantity * $cart->price;
        $cart->total_cost = $cart->quantity * $product->cost_price_bottle;
        $cart->save();

        Toastr::success('Drink successfully added to cart', 'Success');
        return redirect()->back();
    }

    public function exchange_in_cart_update(Request $request, $id){
        $cart = exchangeInCart::find($id);

        $cart->quantity = $request->input('quantity');
        $cart->total = $cart->quantity * $cart->price;
        $product = Product::find($cart->product_id);

        if($product->stock < 1 || $product->stock < $request->input('quantity')){
            Toastr::error('No stock!! Please seek supply.', 'Error');
            return redirect()->back();
        }

        $cart->total_cost = $cart->quantity * $product->cost_price_bottle;

        $cart->save();

        Toastr::success('Cart Updated Successfully', 'Success');
        return redirect()->back();
    }

    public function destroy_cart_in($id)
    {
        $cart = exchangeInCart::find($id);
        $cart->delete();

        Toastr::success('Drink removed Successfully', 'Success');
        return redirect()->back();
    }

    public function exchange_out_cart_store(Request $request){
        // dd($request);
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

        $cart = new exchangeOutCart();
        $cart->product_id = $request->input('product_id');
        $product = Product::find($cart->product_id);

        if($product->stock < 1 || $product->stock < $request->input('quantity')){
            Toastr::error('No stock!! Please seek supply.', 'Error');
            return redirect()->back();
        }

        $cart->name = $request->input('name');
        $cart->quantity = $request->input('quantity');
        $cart->price = $request->input('price');
        $cart->total = $cart->quantity * $cart->price;
        $cart->total_cost = $cart->quantity * $product->cost_price_bottle;
        $cart->save();

        Toastr::success('Drink successfully added to cart', 'Success');
        return redirect()->back();
    }

    public function exchange_out_cart_update(Request $request, $id){
        $cart = exchangeOutCart::find($id);
        $cart->quantity = $request->input('quantity');
        $cart->total = $cart->quantity * $cart->price;
        $product = Product::find($cart->product_id);
        // dd($cart);

        if($product->stock < 1 || $product->stock < $request->input('quantity')){
            Toastr::error('No stock!! Please seek supply.', 'Error');
            return redirect()->back();
        }

        $cart->total_cost = $cart->quantity * $product->cost_price_bottle;

        $cart->save();

        Toastr::success('Cart Updated Successfully', 'Success');
        return redirect()->back();
    }

    public function destroy_cart_out($id)
    {
        $cart = exchangeOutCart::find($id);

        $cart->delete();

        Toastr::success('Drink removed Successfully', 'Success');
        return redirect()->back();
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

        $product_id = $request->input('product_id');
        $product = Product::find($product_id);

        $exchange = new Exchange();
        $exchange->product_id = $request->input('product_id');
        $exchange->name = $request->input('name');
        $exchange->quantity = $request->input('quantity');
        $exchange->price = $request->input('price');
        $exchange->total_cost = $exchange->quantity * $product->cost_price_bottle;
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

        $product = Product::find($exchange->product_id);

        $exchange->quantity = $request->input('quantity');
        $exchange->total_cost = $exchange->quantity * $product->cost_price_bottle;
        $exchange->total = $exchange->quantity * $exchange->price;
        $exchange->save();

        Toastr::success('Exchange Updated Successfully', 'Success');
        return redirect()->back();
    }

    public function final_invoice(Request $request)
    {
        // dd($request);
        $inputs = $request->except('_token');
        // $rules = [
        // //   'payment_status' => 'required',
        // //   'name' => 'required',
        // ];
        // $customMessages = [
        //     // 'payment_status.required' => 'Select a Payment method first!.',
        //     // 'name.required' => 'Please select  a user!'
        // ];

        // $validator = Validator::make($inputs, $rules, $customMessages);
        // if ($validator->fails())
        // {
        //     return redirect()->back()->withErrors($validator)->withInput();
        // }

        // function split_name($name) {
        //     $name = trim($name);
        //     $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
        //     $first_name = trim( preg_replace('#'.preg_quote($last_name,'#').'#', '', $name ) );
        //     return array($first_name, $last_name);
        // }

        // $customer_name = strtolower($request->input('name'));
        // $customer = Customer::where('full_name', $customer_name)->first();
        $order = Order::find($request->order_id);
        // dd($order);
        // out stuffs
        $exchange_out = exchangeOutCart::all();
        $sub_total_out = str_replace(',', '', exchangeOutCart::sum('total'));
        $tax = str_replace(',', '', 0);
        $total_out = str_replace(',', '', exchangeOutCart::sum('total'));
        $cost_out = str_replace(',', '', exchangeOutCart::sum('total_cost'));

        // in stuffs
        $exchange_in = exchangeInCart::all();
        $sub_total_in = str_replace(',', '', exchangeInCart::sum('total'));
        $tax = str_replace(',', '', 0);
        $total_in = str_replace(',', '', exchangeInCart::sum('total'));
        $cost_in = str_replace(',', '', exchangeInCart::sum('total_cost'));

        $debt = $total_out - $total_in;

        $date = $request->date;
        // dd($debt);

        $exchange = new Exchange();
        $exchange->order_id = $request->order_id;
        $exchange->amount = $debt;
        $exchange->save();

        foreach ($exchange_out as $drink) {
            $product = Product::find($drink->product_id);
            $product->stock -= $drink->quantity;
            $product->save();

            $x_out = new ExchangeOut();
            $x_out->product_id = $drink->product_id;
            $x_out->exchange_id = $exchange->id;
            $x_out->name = $drink->name;
            $x_out->quantity = $drink->quantity;
            $x_out->price = $drink->price;
            $x_out->total_cost = $drink->total_cost;
            $x_out->total = $drink->total;
            // $x_out->created_at = $date;
            $x_out->save();
        }

        foreach ($exchange_in as $drink) {
            $product = Product::find($drink->product_id);
            $product->stock += $drink->quantity;
            $product->save();

            $x_in = new ExchangeIn();
            $x_in->product_id = $drink->product_id;
            $x_in->exchange_id = $exchange->id;
            $x_in->name = $drink->name;
            $x_in->quantity = $drink->quantity;
            $x_in->price = $drink->price;
            $x_in->total = $drink->total;
            // $x_in->created_at = $date;
            $x_in->save();
        }

        $order = Order::find($order->id);

        if ($debt < 0) {
            $order->to_balance += $debt;
        } else {
            $order->exchange += $debt;
            $order->debt += $debt;
        }
        $order->save();

        // $order->customer_id =  $customer->id;
        // $order->seller = Auth::user()->name;
        // $order->customer_name = $customer->full_name;
        // $order->customer_phone = $customer->phone;
        // $order->payment_status = 'exchange';
        // $order->pay = $x_total;
        // $order->debt = $debt;
        // $order->order_date = date('Y-m-d');
        // $order->order_status = 'confirmed';
        // $order->total_products = Cart::sum('quantity');
        // $order->sub_total = $sub_total;
        // $order->total_cost = $c_total;
        // $order->owing = $order->debt > 0 ? true : false;
        // $order->to_balance = $order->debt < 0 ? true : false;
        // $order->vat = $tax;
        // $order->total = $c_total;
        // $order->created_at = $date;
        // dd($order);

        // foreach ($contents as $content)
        // {
        //     $order_detail = new OrderDetail();
        //     $order_detail->order_id = $order_id;
        //     $order_detail->product_id = $content->id;
        //     $order_detail->quantity = $content->quantity;
        //     $order_detail->unit_cost = $content->price;
        //     $order_detail->total = $content->total;
        //     $order_detail->created_at = $date;

        //     $order_detail->save();
        // }

        exchangeInCart::truncate();
        exchangeOutCart::truncate();

        Toastr::success('Invoice created successfully', 'Success');
        return redirect()->route('admin.order.approved');
    }
}
