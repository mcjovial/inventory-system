<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Debtors;
use App\Setting;
use Illuminate\Http\Request;

class DebtController extends Controller
{
    public function details($id){
        $debtor = Customer::find($id);
        $debts = Debtors::where('customer_id', $id)->get();
        $total = $debts->sum('amount');
        $max_debt = Setting::first()->max_debt;

        // dd($debtor);
        return view('admin.order.debtor_details', compact('debtor', 'debts', 'total', 'max_debt'));
    }
}
