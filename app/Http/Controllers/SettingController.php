<?php

namespace App\Http\Controllers;

use App\Year;
use App\Customer;
use App\Setting;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting = Setting::latest()->first();
        return view('admin.setting', compact('setting'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        //
    }

    public function dues_report()
    {
        $custormers = Customer::all();

        return view('admin.dues.report');
    }

    public function report(){
        $customers = Customer::all();
        $years = Year::all();

        return view('dues_report', compact('customers', 'years'));

    }

    public function member(){
        $customers = Customer::all();

        return view('member', compact('customers'));
    }

    public function member_post(Request $request){
        $customer = Customer::where('full_name', $request->name)->first();
        $settings = Setting::first();

        return view('member_form', compact('customer', 'settings'));
    }

    public function member_update(Request $request, $id)
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

        $customer = Customer::find($id);

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
        
        $customer->title = $request->input('title');
        $customer->sur_name = $request->input('sur_name');
        $customer->first_name = $request->input('first_name');
        $customer->other_name = $request->input('other_name');
        $customer->full_name = $customer->sur_name.' '.$customer->first_name.' '.$customer->other_name;
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
        // dd($customer);
        $customer->save();


        Toastr::success('Customer Successfully Updated', 'Success!!!');
        return redirect()->route('admin.customer.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $inputs = $request->except('_token');
        $rules = [
          'name' => 'required',
          'email' => 'required',
          'mobile' => 'required',
          'address' => 'required',
          'logo' => 'image | nullable',
          'year' => 'required',
          'reg_fee' => 'required',
          'annual' => 'required',
          'max_debt' => 'required',
          'welfare' => 'required'
        ];

        $validation = Validator::make($inputs, $rules);
        if ($validation->fails())
        {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $image = $request->file('logo');
        $slug =  Str::slug($request->input('name'));

        $setting = Setting::findOrFail($id);

        if (isset($image))
        {
            $currentDate = Carbon::now()->toDateString();
            $imageName = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            if (!Storage::disk('public')->exists('setting'))
            {
                Storage::disk('public')->makeDirectory('setting');
            }

            // delete old post photo
            if (Storage::disk('public')->exists('setting/'.$setting->logo))
            {
                Storage::disk('public')->delete('setting/'.$setting->logo);
            }

            $postImage = Image::make($image)->resize(200, 180)->stream();
            Storage::disk('public')->put('setting/'.$imageName, $postImage);

        } else
        {
            $imageName = $setting->logo;
        }


        $setting->name = $request->input('name');
        $setting->email = $request->input('email');
        $setting->phone = $request->input('phone');
        $setting->address = $request->input('address');
        // $setting->city = $request->input('city');
        $setting->mobile = $request->input('mobile');
        // $setting->zip_code = $request->input('zip_code');
        $setting->country = 'Nigeria';
        $setting->year = $request->input('year');
        $setting->reg_fee = $request->input('reg_fee');
        $setting->annual = $request->input('annual');
        $setting->max_debt = $request->input('max_debt');
        $setting->welfare = $request->input('welfare');
        $setting->logo = $imageName;

        $year = new Year();
        $year->number = $request->input('year');
        $year->save();
        $setting->save();

        Toastr::success('Setting Successfully Updated', 'Success!!!');
        return redirect()->route('admin.setting.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
