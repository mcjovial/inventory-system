<?php

namespace App\Http\Controllers;

use App\Product;
use App\Sales;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales = Sales::all();
        return view('admin.sales.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $drinks = Product::all();
        return view('admin.sales.create', compact('drinks'));
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
            'drink_id' => 'required'
        ];

        $validation = Validator::make($inputs, $rules);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $product = Product::find('product_id');
        $cost = $product->cost_price_bottle;
        $sell = $product->sell_price_bottle;

        $sale = new Sales();
        $sale->drink_id = $request->input('product_id');
        $sale->open_stock = $request->input('open_stock');
        $sale->unit_price = $request->input('unit_price');
        $sale->qty = $request->input('qty');
        $sale->profit = $sell - $cost;
        $sale->total_amount = $request->input('total_amount');
        $sale->payment_type = $request->input('payment_type');
        $sale->exchange_in = $request->input('exchange_in');
        $sale->exchange_out = $request->input('exchange_out');
        $sale->cartons_launched = $request->input('cartons_launched');
        $sale->closing_stock = $request->input('closing_stock');
        $sale->save();

        Toastr::success('Sale successfully registered', 'Success!!!');

        return redirect()->route('admin.sale.index');
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
    public function edit(Sales $sale)
    {
        return view('admin.sale.edit', compact('sale'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sales $sale)
    {
        $inputs = $request->except('_token');
        $rules = [
            'drink_id' => 'required'
        ];

        $validation = Validator::make($inputs, $rules);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $sale->drink_id = $request->input('drink_id');
        $sale->open_stock = $request->input('open_stock');
        $sale->unit_price = $request->input('unit_price');
        $sale->qty = $request->input('qty');
        $sale->total_amount = $request->input('total_amount');
        $sale->payment_type = $request->input('payment_type');
        $sale->exchange_in = $request->input('exchange_in');
        $sale->exchange_out = $request->input('exchange_out');
        $sale->cartons_launched = $request->input('cartons_launched');
        $sale->closing_stock = $request->input('closing_stock');
        $sale->save();

        Toastr::success('Sale updated successfully', 'Success');
        return redirect()->route('admin.sale.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sales $sale)
    {
        $sale->delete();

        Toastr::success('Sale deleted successfully', 'Success!!!');
        return redirect()->route('admin.sale.index');
    }
}
