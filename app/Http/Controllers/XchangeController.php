<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Customer;
use App\Exchange;
use App\Product;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class XchangeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cart_products = Cart::all();
        $cart = Cart::all();
        $drinks = Product::all();

        $exchange_products = Exchange::all();
        $exchange = Exchange::all();

        $customers = Customer::all();

        return view('admin.pos.exchange', compact('cart_products', 'cart', 'drinks', 'exchange_products', 'exchange', 'customers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $exchange = Exchange::find($id);

        $product = Product::find($exchange->product_id);

        $exchange->quantity = $request->input('quantity');
        $exchange->total_cost = $exchange->quantity * $product->cost_price_bottle;
        $exchange->total = $exchange->quantity * $exchange->price;
        $exchange->save();

        Toastr::success('Exchange Updated Successfully', 'Success');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $exchange = Exchange::find($id);
        $exchange->delete();

        Toastr::success('Drink removed Successfully', 'Success');
        return redirect()->back();
    }
}
