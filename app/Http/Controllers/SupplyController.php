<?php

namespace App\Http\Controllers;

use App\Supply;
use App\Product;
use App\Supplier;
use App\Expense;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use IIluminate\Support\Str;

class SupplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $drinks = Product::all();
        $supplies = Supply::latest()->with('product', 'supplier')->get();
        // $products = Product::latest()->with('category', 'supplier')->get();
        // dd($supplies[0]->drink);
        return view('admin.supply.index', compact('drinks', 'supplies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $drinks = Product::all();
        $suppliers = Supplier::all();
        return view('admin.supply.create', compact('drinks', 'suppliers'));
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
            'product_name'  => 'required | string',
            'supplier_id'   => 'required | integer',
            'quantity'       => 'required',
            'cost_per_pack'     => 'required | integer',
        ];

        $validation = Validator::make($inputs, $rules);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $supply = new Supply();
        $supply->product_id = Product::where('name',$request->input('product_name'))->first()->id;
        $supply->supplier_id = $request->input('supplier_id');
        $supply->quantity = $request->input('quantity');
        $supply->save();

        $drink = Product::findOrFail($supply->product_id);
        $drink->cost_price_pack = $request->input('cost_per_pack');
        $num = $drink->bottles_per_pack;
        $pieces = $request->input('quantity') * $num;
        $drink->stock += $pieces;
        $drink->cost_price_bottle = $drink->cost_price_pack / $num;
        $drink->save();

        $date = Carbon::now();

        $expense = new Expense();
        $expense->name = $drink->name;
        $expense->amount = $drink->cost_price_pack * $supply->quantity;
        $expense->month = $date->format('F');
        $expense->year = $date->format('Y');
        $expense->date = $date->format('Y-m-d');
        $expense->save();

        Toastr::success('Supply is successfully registered', 'Success!!!');
        return redirect()->route('admin.supply.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Supply $supply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Supply $supply)
    {
        $suppliers = Supplier::all();
        $drinks = Product::all();
        return view('admin.supply.edit', compact('suppliers', 'drinks', 'supply'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supply $supply)
    {
        $inputs = $request->except('_token');
        $rules = [
            'product_id'  => 'required | integer',
            'supplier_id'   => 'required | integer',
            'quantity'       => 'required'
        ];

        $validation = Validator::make($inputs, $rules);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $supply->product_id = $request->input('product_id');
        $supply->supplier_id = $request->input('supplier_id');
        $supply->quantity = $request->input('quantity');
        $supply->save();

        Toastr::success('Supply is successfully registered', 'Success!!!');
        return redirect()->route('admin.supply.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supply $supply)
    {
        $supply->delete();

        Toastr::success('Supply successfully deleted', 'Success!!!');
        return redirect()->route('admin.supply.index');
    }
}
