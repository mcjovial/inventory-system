<?php

namespace App\Http\Controllers;

use App\Balance;
use App\Order;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BalanceController extends Controller
{
    public function index() {
        $balances = Balance::all();

        return view('admin.balance.index', compact('balances'));
    }

    public function create($id) {
        $order = Order::find($id);

        return view('admin.balance.create', compact('order'));
    }

    public function store(Request $request)
    {
        $inputs = $request->except('_token');
        $rules = [
            'customer_id'       =>  'required | integer',
            'order_id'          =>  'required | integer',
            'description'       =>  'required',
            'amount'            =>  'required | integer',
            'pay_out'           =>  'required'
        ];

        $validation = Validator::make($inputs, $rules);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $balance = new Balance();
        $balance->customer_id = $request->input('customer_id');
        $balance->order_id = $request->input('order_id');
        $balance->description = $request->input('description');
        $balance->amount = $request->input('amount');
        $balance->pay_out = $request->input('pay_out');
        $balance->save();

        Toastr::success('Order balanced successfully', 'Success!!!');
        return redirect()->route('admin.balance.index');
    }

    public function edit($id) {
        $balance = Balance::find($id);

        return view('admin.balance.edit', compact('balance'));
    }

    public function update(Request $request, $id)
    {
        $inputs = $request->except('_token');
        $rules = [
            'customer_id'       =>  'required | integer',
            'order_id'          =>  'required | integer',
            'description'       =>  'required',
            'amount'            =>  'required | integer',
            'pay_out'           =>  'required'
        ];

        $validation = Validator::make($inputs, $rules);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $balance = Balance::find($id);
        $balance->customer_id = $request->input('customer_id');
        $balance->order_id = $request->input('order_id');
        $balance->description = $request->input('description');
        $balance->amount = $request->input('amount');
        $balance->pay_out = $request->input('pay_out');
        $balance->save();

        Toastr::success('Balanced updated successfully', 'Success!!!');
        return redirect()->route('admin.balance.index');
    }

    public function destroy($id)
    {
        $balance = Balance::find($id);
        $balance->delete();

        Toastr::success('Balance delted succesfully', 'Success!!!');
        return redirect()->route('admin.balance.index');
    }
}
