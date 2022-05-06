<?php

namespace App\Http\Controllers;

use Auth;
use App\Cart;
use App\Launch;
use App\Debtors;
use App\Balance;
use App\Customer;
use App\Expense;
use App\Order;
use App\OrderDetail;
use App\Product;
use App\Setting;
use App\Transfer;
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
        // $pendings = Order::latest()->with('customer')->where('order_status', 'pending')->get();
        $pendings = Debtors::where('transfer', true)->get();

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
        $debtors = Debtors::all();

        return view('admin.order.credit_orders', compact('credits', 'debtors'));
    }

    public function order_confirm($id)
    {        
        $debtor = Debtors::findOrFail($id);
        $order = Order::findOrFail($debtor->order_id);
        $order->pay += $debtor->amount;
        // $order->total += $debtor->amount;
        $order->debt -= $debtor->amount;
        $order->save();

        $transfer = new Transfer();
        $transfer->customer_id = $debtor->customer_id;
        $transfer->order_id = $debtor->order_id;
        $transfer->amount = $debtor->amount;
        $transfer->save();

        $debtor->delete();

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
            // 'description'       =>  'required',
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
            // dd(abs($order->debt - $request->input('amount')));
            $debt = $order->debt - $request->input('amount');
            // dd($debt);
            if ($debt == 0.0) {
                $order->owing = false;
            } else {
                $order->owing = true;
            }

            $order->pay += $request->amount;
            if (!$order->payment_status == 'transfer') {
                $order->pay += $debt;
            }
        }
        
        $order->debt = $debt;
        $order->save();

        $debtor = Debtors::findOrFail($request->debtor_id);
        if ($debtor->amount == $request->amount) {
            $debtor->delete();
        }

        if ($debtor->amount > $request->amount) {
            $debtor->amount -= $request->amount;
            $debtor->save();
        }

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
            ->select('customers.full_name as customer_name', 'products.name AS product_name', 'products.image', 'order_details.*')
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
            ->select('customers.full_name as customer_name', 'products.name AS product_name', 'products.image', 'order_details.*')
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
            ->select('customers.full_name as customer_name', 'products.name AS product_name', 'products.image', 'order_details.*')
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
            ->select('customers.full_name as customer_name', 'products.name AS product_name','products.image', 'order_details.*')
            ->orderBy('order_details.created_at', 'desc')
            ->get();

        return view('admin.sales.index', compact('balance', 'orders', 'products', 'order_details'));
    }

    public function debtors_create(){

        $customers = Customer::all();
        $sales = Order::where('owing', true)->get();

        return view('admin.order.create_debtor', compact('customers', 'sales'));
    }

    public function debtors_create_id($id){

        $customers = Customer::all();
        $order = Order::find($id);

        return view('admin.order.create_debtor_id', compact('customers', 'order'));
    }

    public function transfer_create(){

        $customers = Customer::all();
        $orders = Order::all();

        return view('admin.order.create_transfer', compact('customers', 'orders'));
    }

    public function transfer_create_id($id){

        $customers = Customer::all();
        $order = Order::find($id);

        return view('admin.order.create_transfer_id', compact('customers', 'order'));
    }

    public function launch($id){
        $cart_products = Cart::all();
        $cart = Cart::all();
        $drinks = Product::all();

        $Launch_products = Launch::all();
        $Launch = Launch::all();

        $customers = Customer::all();
        $order = Order::find($id);

        return view('admin.pos.launch', compact('cart_products', 'cart', 'drinks', 'customers', 'order'));
    }


    public function debtors_store(Request $request)
    {
        $inputs = $request->except('_token');
        $rules = [
            'amount' => 'required',
          'oder_id' => 'required',
          'name' => 'required',
        ];
        $customMessages = [
            'amount.required' => 'Input amount!',
            'name.required' => 'Select a Customer name first!.',
        ];

        $validator = Validator::make($inputs, $rules, $customMessages);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $customer = Customer::where('full_name', $request->name)->first();
        $date = $request->date;

        $order = Order::find($request->order_id);
        $order->debt += $request->amount;
        $order->save();

        // $order->customer_id =  $customer->id;
        // $order->seller = Auth::user()->name;
        // $order->customer_name = $request->input('name');
        // $order->customer_phone = $customer->phone;
        // $order->payment_status = 'credit';
        // $order->debt = $request->amount;
        // $order->order_date = date('Y-m-d');
        // $order->order_status = 'confirmed';
        // $order->owing = true;
        // $order->to_balance = false;
        // $order->sub_total = $request->amount;
        // $order->total = $request->amount;
        // $order->created_at = $request->date;
        // dd($order);

        $debtor = new Debtors();
        $debtor->order_id = $order->id;
        $debtor->customer_id = $customer->id;
        $debtor->amount = $request->amount;
        $debtor->transfer = false;
        $debtor->save();

        Toastr::success('Debtor added successfully', 'Success');

        return redirect()->route('admin.order.credit');
    }

    public function transfer_store(Request $request)
    {
        $inputs = $request->except('_token');
        $rules = [
            'amount' => 'required',
          'order_id' => 'required',
          'name' => 'required',
        ];
        $customMessages = [
            'amount.required' => 'Input amount!',
            'name.required' => 'Select a Customer name first!.',
        ];

        $validator = Validator::make($inputs, $rules, $customMessages);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $customer = Customer::where('full_name', $request->name)->first();

        $order = Order::find($request->order_id);
        // Subtract transfered amount from total CAH for that day and add to debt
        // $order->pay -= $request->amount;
        $order->debt += $request->amount;
        $order->save();

        $debtor = new Debtors();
        $debtor->order_id = $order->id;
        $debtor->customer_id = $customer->id;
        $debtor->amount = $request->amount;
        $debtor->transfer = true;
        $debtor->save();

        Toastr::success('Transfer added successfully', 'Success');

        return redirect()->route('admin.order.credit');
    }
}
