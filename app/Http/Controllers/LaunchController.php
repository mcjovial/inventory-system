<?php

namespace App\Http\Controllers;

use Auth;
use App\Cart;
use App\Customer;
use App\Debtors;
use App\Launch;
use App\Order;
use App\OrderDetail;
use App\Product;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function PHPSTORM_META\type;

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

        $product = Product::find($request->input('product_id'));

        if($product->stock < 1 || $product->stock < ($request->input('cartons') * 12)){
            Toastr::error('No stock!! Please seek supply.', 'Error');
            return redirect()->back();
        }

        $cart = new Cart();
        $cart->product_id = $request->input('product_id');
        $cart->name = $request->input('name');
        $cart->cartons = $request->input('cartons');
        $cart->quantity = $cart->cartons * $product->launch_cartons;
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
        $product = Product::find($cart->product_id);

        if($product->stock < 1 || $product->stock < ($request->input('cartons') * 12)){
            Toastr::error('No stock!! Please seek supply.', 'Error');
            return redirect()->back();
        }
        
        $cart->cartons = $request->input('cartons');
        $cart->quantity = $cart->cartons * $product->launch_cartons;
        $cart->total = $cart->quantity * $cart->price;
        $cart->save();

        Toastr::success('Cart Updated Successfully', 'Success');
        return redirect()->back();
    }

    public function final_invoice(Request $request)
    {
        // dd($request);
        $inputs = $request->except('_token');
        $rules = [
          'pay' => 'required',
          'name' => 'required',
        ];
        $customMessages = [
            'pay.required' => 'Select a Payment method first!.',
            'name.required' => 'Select a Customer!.',
        ];

        $validator = Validator::make($inputs, $rules, $customMessages);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $customer_name = strtolower($request->input('name'));
        $customer = Customer::where('full_name', $customer_name)->first();
        // dd($customer);

        // cart stuffs
        $cart_products = Cart::all();
        $sub_total = str_replace(',', '', Cart::sum('total'));
        $tax = str_replace(',', '', 0);
        $c_total = str_replace(',', '', Cart::sum('total'));

        $date = $request->date;

        $order = Order::find($request->order_id);
        // dd($order);

        foreach ($cart_products as $drink) {
            $product = Product::find($drink->product_id);
            $product->stock -= $drink->quantity;
            $product->save();

            $launch = new Launch();
            $launch->order_id = $order->id;
            $launch->customer_id = $customer->id;
            $launch->product_id = $drink->product_id;
            $launch->method = $request->pay;
            $launch->name = $drink->name;
            $launch->cartons = $drink->cartons;
            $launch->quantity = $drink->quantity;
            $launch->price = $drink->price;
            $launch->total = $drink->total;
            $launch->created_at = $date;
            $launch->save();
        }

        $order = Order::find($order->id);
        $order->total_products += Cart::sum('quantity');
        $order->launch += $c_total;
        $order->sub_total += $sub_total;
        $order->total += $sub_total;
        $order->vat = $tax;

        if ($request->pay == 'cash') {
            $order->total += $c_total;
            $order->pay += $c_total;
        } else {
            $order->debt += $c_total;
            
            $debtor = new Debtors();
            $debtor->order_id = $order->id;
            $debtor->customer_id = $customer->id;
            $debtor->amount = $c_total;
            $debtor->transfer = true;
            $debtor->save();
        }
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
            $order_detail->created_at = $date;
            $order_detail->save();
        }

        Cart::truncate();

        Toastr::success('Invoice created successfully', 'Success');

        if ($order->order_status == 'pending') {
            return redirect()->route('admin.order.pending');
        } else {
            return redirect()->route('admin.order.approved');
        }
    }
}
