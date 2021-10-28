<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Product;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
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
        //
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

        $cart = new Cart();
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
    public function update(Request $request, Cart $cart)
    {
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        $cart->delete();

        Toastr::success('Drink removed Successfully', 'Success');
        return redirect()->back();
    }
}
