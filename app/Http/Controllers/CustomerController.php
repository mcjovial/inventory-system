<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Dues;
use App\Setting;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::latest()->get();
        return view('admin.customer.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $settings = Setting::first();

        return view('admin.customer.create', compact('settings'));
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
            'email' => 'required| email | unique:customers',
            'phone' => 'required | unique:customers',
            'address' => 'required',
            'photo' => 'image',
        ];

        $validation = Validator::make($inputs, $rules);
        if ($validation->fails())
        {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $image = $request->file('photo');
        $slug =  Str::slug($request->input('name'));
        if (isset($image))
        {
            $currentDate = Carbon::now()->toDateString();
            $imageName = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            if (!Storage::disk('public')->exists('customer'))
            {
                Storage::disk('public')->makeDirectory('customer');
            }
            $postImage = Image::make($image)->resize(480, 320)->stream();
            Storage::disk('public')->put('customer/'.$imageName, $postImage);
        } else
        {
            $imageName = 'default.png';
        }

        $settings = Setting::first();

        $customer = new Customer();
        $customer->sur_name = $request->input('sur_name');
        $customer->first_name = $request->input('first_name');
        $customer->other_name = $request->input('other_name');
        $customer->b_month = $request->input('b_month');
        $customer->b_day = $request->input('b_day');
        $customer->email = $request->input('email');
        $customer->phone = $request->input('phone');
        $customer->pow = $request->input('pow');
        $customer->address = $request->input('address');
        $customer->type = $request->input('type');
        $customer->state = $request->input('state');
        $customer->debt = $settings->reg_fee - $request->input('reg_fee');
        $customer->reg_fee = $request->input('reg_fee');

        if ($request->input('reg_fee') != $settings->reg_fee){
            $customer->status = false;
        } else {
            $customer->status = true;
        }
        $customer->photo = $imageName;
        $customer->save();

        Toastr::success('Customer Successfully Created', 'Success!!!');
        return redirect()->route('admin.customer.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        return view('admin.customer.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        $settings = Setting::first();
        return view('admin.customer.edit', compact('customer', 'settings'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        $inputs = $request->except('_token');
        $rules = [
            'email' => 'required| email',
            'phone' => 'required',
            'address' => 'required',
            'photo' => 'image',
        ];

        $validation = Validator::make($inputs, $rules);
        if ($validation->fails())
        {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $image = $request->file('photo');
        $slug =  Str::slug($request->input('name'));
        if (isset($image))
        {
            $currentDate = Carbon::now()->toDateString();
            $imageName = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            if (!Storage::disk('public')->exists('customer'))
            {
                Storage::disk('public')->makeDirectory('customer');
            }

            // delete old photo
            if (Storage::disk('public')->exists('customer/'. $customer->photo))
            {
                Storage::disk('public')->delete('customer/'. $customer->photo);
            }

            $postImage = Image::make($image)->resize(480, 320)->stream();
            Storage::disk('public')->put('customer/'.$imageName, $postImage);
        } else
        {
            $imageName = $customer->photo;
        }

        $settings = Setting::first();

        $customer->sur_name = $request->input('sur_name');
        $customer->first_name = $request->input('first_name');
        $customer->other_name = $request->input('other_name');
        $customer->b_month = $request->input('b_month');
        $customer->b_day = $request->input('b_day');
        $customer->email = $request->input('email');
        $customer->phone = $request->input('phone');
        $customer->pow = $request->input('pow');
        $customer->address = $request->input('address');
        $customer->type = $request->input('type');
        $customer->state = $request->input('state');
        $customer->reg_fee = $request->input('reg_fee');
        $customer->debt = $settings->reg_fee - $customer->reg_fee;

        if ($customer->reg_fee != $settings->reg_fee){
            $customer->status = false;
        } else {
            $customer->status = true;
        }

        $customer->photo = $imageName;
        $customer->save();


        Toastr::success('Customer Successfully Updated', 'Success!!!');
        return redirect()->route('admin.customer.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        if (Storage::disk('public')->exists('customer/'. $customer->photo))
        {
            Storage::disk('public')->delete('customer/'. $customer->photo);
        }
        $customer->delete();
        Toastr::success('Customer Successfully Deleted', 'Success!!!');
        return redirect()->route('admin.customer.index');
    }
}
