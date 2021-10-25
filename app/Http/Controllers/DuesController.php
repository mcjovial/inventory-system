<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Dues;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DuesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dues = Dues:: all();

        return view('admin.dues.index', compact('dues'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Customer::all();

        return view('admin.dues.create', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->except('_token');
        $rules = [
            'customer_id' =>    'required',

        ];

        $validation = Validator::make($input, $rules);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $due = new Dues();
        $due->customer_id = $request->input('customer_id');
        $due->reg_fee = $request->input('reg_fee');
        if ($request->input('reg_fee')) {
            $due->reg_fee_date = Carbon::now()->format('Y-m-d');
        }

        $due->annual = $request->input('annual');
        if ($request->input('annual')) {
            $due->annual_date = Carbon::now()->format('Y-m-d');
            $due->annual_expire = date('Y-m-d', strtotime('+1 years'));
        }

        $due->welfare = $request->input('welfare');
        if ($request->input('welfare')) {
            $due->welfare_date = Carbon::now()->format('Y-m-d');
            $due->welfare_expire = date('Y-m-d', strtotime('+1 years'));
        }
        $due->save();

        Toastr::success('Dues Successfully Paid', 'Success!!!');
        return redirect()->route('admin.dues.index');
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
    public function edit(Dues $due)
    {
        $customer = Customer::all();
        return view('admin.dues.edit', compact('due', 'customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dues $due)
    {
        $input = $request->except('_token');
        $rules = [
            // 'customer_id' =>    'required',

        ];

        $validation = Validator::make($input, $rules);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        // $due->customer_id = $request->input('customer_id');
        $due->reg_fee = $request->input('reg_fee');
        if ($request->input('reg_fee')) {
            $due->reg_fee_date = Carbon::now()->format('Y-m-d');
        }

        $due->annual = $request->input('annual');
        if ($request->input('annual')) {
            $due->annual_date = Carbon::now()->format('Y-m-d');
            $due->annual_expire = date('Y-m-d', strtotime('+1 years'));
        }

        $due->welfare = $request->input('welfare');
        if ($request->input('welfare')) {
            $due->welfare_date = Carbon::now()->format('Y-m-d');
            $due->welfare_expire = date('Y-m-d', strtotime('+1 years'));
        }
        $due->save();

        Toastr::success('Dues Updated Successfully', 'Success!!!');
        return redirect()->route('admin.dues.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
