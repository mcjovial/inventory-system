<?php

namespace App\Http\Controllers;

use Auth;
use App\Balance;
use App\Expense;
use App\Order;
use App\OrderDetail;
use App\Product;
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
        $order->owing = $order->debt > 0 ? true : false;
        $order->save();

        Toastr::success('Payment has been Confirmed!', 'Success');
        return redirect()->route('admin.order.approved');
    }

    public function destroy($id)
    {
        Order::findOrFail($id)->delete();
        Toastr::success('Payment has been deleted', 'Success');
        return redirect()->back();
    }

    public function to_balance(){
        $credits = Order::latest()->where('to_balance', true)->get();
        return view('admin.order.to_balance', compact('credits'));
    }

    public function balance(Request $request, $id){
        // dd($request);
        $inputs = $request->except('_token');
        $rules = [
            'customer_id'       =>  'required',
            // 'customer_phone'       =>  'required',
            'order_id'          =>  'required | integer',
            'description'       =>  'required',
            'amount'            =>  'required | integer',
        ];

        $validation = Validator::make($inputs, $rules);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $balance = new Balance();
        $balance->seller = Auth::user()->name;
        $balance->customer_id = $request->input('customer_id');
        // $balance-> = $request->input('customer_name');
        // $balance->customer_phone = $request->input('customer_phone');
        $balance->order_id = $request->input('order_id');
        $balance->description = $request->input('description');
        $balance->amount = $request->input('amount');
        $balance->pay_out = $request->input('pay_out');
        // dd($balance->pay_out);
        $balance->save();

        $order = Order::findOrFail($request->input('order_id'));
        if ($request->input('pay_out')) {
            $order->to_balance = false;
            $debt = abs($order->debt);
            // dd($debt);
            $order->pay -= $debt;
        } else {
            $order->owing = false;
            $debt = abs($order->debt);
            // dd($debt);
            $order->pay += $debt;
        }

        $order->debt = 0;
        // dd($order);
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

        Storage::put('public/pdf/'.$order->customer->full_name .'-'. str_pad($order->id,9,"0",STR_PAD_LEFT). '.pdf' ,$content) ;

        Toastr::success('PDF successfully saved', 'Success');
        return redirect()->back();

    }

    // for sales report
    public function today_sales()
    {
        $day = date('Y-m-d');

        $balance = Order::whereDate('order_date', $day)->get();
        $products = Product::all();
        $order_details = OrderDetail::whereDate('created_at', $day)->get();

        $orders = DB::table('orders')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->join('customers', 'orders.customer_id', '=', 'customers.id')
            ->select('customers.name as customer_name', 'products.name AS product_name', 'products.image', 'order_details.*')
            ->where('orders.order_date' , '=', $day)
            ->orderBy('order_details.created_at', 'desc')
            ->get();

        return view('admin.sales.today', compact('orders', 'balance', 'products', 'order_details', 'day'));
    }

    public function day_sales(Request $request)
    {
        $day = $request->input('date');
        // dd($day);
        if ($day == null)
        {
            $day = date('Y-m-d');
        } else {
            $day = date('Y-m-d', strtotime($day));
        }
        // $date = "2021-10-22";
        // dd(date('Y-m-d', strtotime($date)));
        // $today = date('Y-m-d');

        $balance = Order::whereDate('order_date', $day)->get();
        $products = Product::all();
        $order_details = OrderDetail::whereDate('created_at', $day)->get();

        $orders = DB::table('orders')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->join('customers', 'orders.customer_id', '=', 'customers.id')
            ->select('customers.name as customer_name', 'products.name AS product_name', 'products.image', 'order_details.*')
            ->where('orders.order_date' , '=', $day)
            ->orderBy('order_details.created_at', 'desc')
            ->get();

        return view('admin.sales.today', compact('orders', 'balance', 'products', 'order_details', 'day'));
    }

    public function monthly_sales($month = null)
    {

        if ($month == null)
        {
            $month = date('m');
        } else {
            $month = date('m', strtotime($month));
        }
        // dd($month);

        $balance = Order::whereMonth('order_date', $month)->get();
        $products = Product::all();
        $order_details = OrderDetail::whereMonth('created_at', $month)->get();

        $orders = DB::table('orders')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->join('customers', 'orders.customer_id', '=', 'customers.id')
            ->select('customers.name as customer_name', 'products.name AS product_name', 'products.image', 'order_details.*')
            ->whereMonth('orders.created_at' , '=', $month)
            ->orderBy('order_details.created_at', 'desc')
            ->get();

        return view('admin.sales.month', compact('orders', 'month', 'balance', 'products', 'order_details',));
    }

    public function total_sales()
    {
        $balance = Order::all();
        $products = Product::all();
        $order_details = OrderDetail::all();

        $orders = DB::table('orders')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->join('customers', 'orders.customer_id', '=', 'customers.id')
            ->select('customers.name as customer_name', 'products.name AS product_name','products.image', 'order_details.*')
            ->orderBy('order_details.created_at', 'desc')
            ->get();

        return view('admin.sales.index', compact('balance', 'orders', 'products', 'order_details'));
    }


}
