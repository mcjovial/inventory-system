<?php

namespace App\Http\Controllers;

use App\Balance;
use App\Expense;
use App\Order;
use App\OrderDetail;
use App\Setting;
use Barryvdh\DomPDF\Facade as PDF;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{

    public function show($id)
    {
        $order = Order::with('customer')->where('id', $id)->first();
        //return $order;
        $order_details = OrderDetail::with('product')->where('order_id', $id)->get();
        //return $order_details;
        $company = Setting::latest()->first();
        return view('admin.order.order_confirmation', compact('order_details', 'order', 'company'));
    }


    public function pending_order()
    {
        $pendings = Order::latest()->with('customer')->where('order_status', 'pending')->get();
        return view('admin.order.pending_orders', compact('pendings'));
    }

    public function approved_order()
    {
        $approveds = Order::latest()->with('customer')->where('order_status', 'confirmed')->get();
        return view('admin.order.approved_orders', compact('approveds'));
    }

    public function credit_order()
    {
        $credits = Order::latest()->where('owing', true)->get();
        return view('admin.order.credit_orders', compact('credits'));
    }

    public function order_confirm($id)
    {
        $order = Order::findOrFail($id);
        $order->order_status = 'confirmed';
        $order->owing = $order->due > 0 ? true : false;
        $order->save();

        Toastr::success('Payment has been Confirmed!', 'Success');
        return redirect()->back();
    }

    public function destroy($id)
    {
        Order::findOrFail($id)->delete();
        Toastr::success('Payment has been deleted', 'Success');
        return redirect()->back();
    }

    public function balance(Request $request, $id){
        $inputs = $request->except('_token');
        $rules = [
            'customer_id'       =>  'required | integer',
            'order_id'          =>  'required | integer',
            'description'       =>  'required',
            'amount'            =>  'required | integer',
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
        $balance->pay_out = $request->input('pay_out') ? true : false;
        $balance->save();

        $order = Order::findOrFail($request->input('order_id'));
        $order->due = 0;
        if ($request->input('pay_out')) {
            $order->to_balance = false;
        } else {
            $order->owing = false;
        }
        $order->pay += abs($order->due);
        $order->save();

        Toastr::success('Order balanced successfully', 'Success!!!');
        return redirect()->route('admin.balance.index');
    }

    public function download($order_id)
    {
        $order = Order::with('customer')->where('id', $order_id)->first();
        //return $order;
        $order_details = OrderDetail::with('product')->where('order_id', $order_id)->get();
        //return $order_details;
        $company = Setting::latest()->first();

        set_time_limit(300);

        $pdf = PDF::loadView('admin.order.pdf', ['order'=>$order, 'order_details'=> $order_details, 'company'=> $company]);

        $content = $pdf->download()->getOriginalContent();

        Storage::put('public/pdf/'.$order->customer->name .'-'. str_pad($order->id,9,"0",STR_PAD_LEFT). '.pdf' ,$content) ;

        Toastr::success('PDF successfully saved', 'Success');
        return redirect()->back();

    }

    // for sales report
    public function today_sales()
    {
        $today = date('Y-m-d');

        $balance = Order::where('order_date', $today)->get();

        $orders = DB::table('orders')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->join('customers', 'orders.customer_id', '=', 'customers.id')
            ->select('customers.name as customer_name', 'products.name AS product_name', 'products.image', 'order_details.*')
            ->where('orders.order_date' , '=', $today)
            ->orderBy('order_details.created_at', 'desc')
            ->get();

        return view('admin.sales.today', compact('orders', 'balance'));
    }

    public function monthly_sales($month = null)
    {

        if ($month == null)
        {
            $month = date('m');
        } else {
            $month = date('m', strtotime($month));
        }

        $balance = Order::whereMonth('order_date', $month)->get();

        $orders = DB::table('orders')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->join('customers', 'orders.customer_id', '=', 'customers.id')
            ->select('customers.name as customer_name', 'products.name AS product_name', 'products.image', 'order_details.*')
            ->whereMonth('orders.created_at' , '=', $month)
            ->orderBy('order_details.created_at', 'desc')
            ->get();

        return view('admin.sales.month', compact('orders', 'month', 'balance'));
    }

    public function total_sales()
    {
        $balance = Order::all();

        $orders = DB::table('orders')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->join('customers', 'orders.customer_id', '=', 'customers.id')
            ->select('customers.name as customer_name', 'products.name AS product_name','products.image', 'order_details.*')
            ->orderBy('order_details.created_at', 'desc')
            ->get();

        return view('admin.sales.index', compact('balance', 'orders'));
    }


}
