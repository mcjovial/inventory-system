<?php

namespace App\Http\Controllers;

use Auth;
use App\Flat;
use App\Order;
use App\Product;
use App\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FlatController extends Controller
{
    public function index(){
        $flats = Flat::latest()->get();
        $drinks = Product::all();
        // dd($flats[0]);
        return view('admin.flat.index', compact('flats', 'drinks'));
    }

    public function create($order_id){
        $order = Order::find($order_id);
        $customers = Customer::all();
        $drinks = $order->order_details;
        // dd($drinks->product->name);

        return view('admin.flat.create', compact('order', 'customers', 'drinks'));
    }

    public function store(Request $request){
        $inputs = $request->except('_token');
        $rules = [
          'quantity' => 'required',
          'product_id' => 'required',
        ];
        $customMessages = [
            'quantity.required' => 'Quantity cannot be empty!.',
            'product_id.required' => 'Select a Drink!.',
        ];

        $validator = Validator::make($inputs, $rules, $customMessages);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $id = $request->input('product_id');

        $product = Product::find($id);

        $flat = new Flat();
        $flat->order_id = $request->input('order_id');
        $flat->product_id = $request->input('product_id');
        $flat->seller = Auth::user()->name;
        $flat->quantity = $request->input('quantity');
        $flat->total = ($product->sell_price_bottle * $flat->quantity);

        $order = Order::find($flat->order_id);
        $order->total_products -= $flat->quantity;
        $order->total -= $flat->total;
        $order->sub_total = $order->total;
        
        $order->save();
        $flat->save();

        Toastr::success('Flat Drink Successfully Registered', 'Success!!!');
        return redirect()->route('admin.flat');
    }

    public function edit($id){
        $flat = Flat::find($id);

        return view('admin.flat.edit', compact('flat'));
    }

    public function update(Request $request, $id){
        $pid = $request->input('product_id');
        $product = Product::find($pid);

        $flat = Flat::find($id);
        $flat->product_id = $request->input('product_id');
        $flat->quantity = $request->input('quantity');
        $flat->total = ($product->sell_price_bottle * $flat->quantity);
        $flat->save();

        Toastr::success('Flat Drink Successfully Updated', 'Success!!!');
        return redirect()->route('admin.flat.index');
    }

    public function destroy($id){
        $flat = Flat::find($id);

        $order = Order::find($flat->order_id);
        $order->total_products += $flat->quantity;
        $order->total += $flat->total;
        $order->sub_total = $order->total;
        
        $order->save();

        $flat->delete();

        Toastr::success('Flat Drink Successfully Deleted', 'Success!!!');
        return redirect()->route('admin.flat');
    }
}
