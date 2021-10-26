<?php

namespace App\Http\Controllers;

use App\Expense;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today_date = date('Y-m-d');
        $today = Order::whereDate('created_at', $today_date)->get();
        $yesterday = Order::whereDate('created_at', date('Y-m-d', strtotime('-1 day')))->get();

        $month_date = date('m');
        $month = Order::whereMonth('created_at', $month_date)->get();
        $previous_month = Order::whereMonth('created_at', date('m', strtotime('-1 month')))->get();

        $year_date = date('Y');
        $year = Order::whereYear('created_at', $year_date)->get();
        $previous_year = Order::whereYear('created_at', date('Y', strtotime('-1 year')))->get();

        $sales = Order::all();

        $today_expenses = Expense::whereDate('created_at', $today_date)->get();
        $yesterday_expenses = Expense::whereDate('created_at', date('Y-m-d', strtotime('-1 day')))->get();

        $month_expenses = Expense::whereMonth('created_at', $month_date)->get();
        $previous_month_expenses = Expense::whereMonth('created_at', date('m', strtotime('-1 month')))->get();

        $year_expenses = Expense::whereYear('created_at', $year_date)->get();
        $previous_year_expenses = Expense::whereYear('created_at', date('Y', strtotime('-1 year')))->get();

        $expenses = Expense::all();

        $profit = Order::sum('total');
        $today_profit = $today->sum('total') - $today->sum('total_cost');
        $month_profit = $month->sum('total') - $month->sum('total_cost');
        $year_profit = $year->sum('total') - $year->sum('total_cost');
        $yesterday_profit = $yesterday->sum('total') - $yesterday->sum('total_cost');
        $previous_month_profit = $previous_month->sum('total') - $previous_month->sum('total_cost');
        $previous_year_profit = $previous_year->sum('total') - $previous_year->sum('total_cost');
        // dd($year_profit);

        // for charts
        $current_sales = Order::select(
            DB::raw('sum(total) as sums'),
            DB::raw("DATE_FORMAT(created_at,'%m') as months"),
            DB::raw("DATE_FORMAT(created_at,'%Y') as year"))
            ->whereYear('created_at',  date('Y'))
            ->groupBy('months')->get();

        $current_expenses = Expense::select(
            DB::raw('sum(amount) as sums'),
            DB::raw("DATE_FORMAT(created_at,'%m') as months"),
            DB::raw("DATE_FORMAT(created_at,'%Y') as year"))
            ->whereYear('created_at',  date('Y'))
            ->groupBy('months')->get();



        return view('admin.dashboard', compact('profit', 'today','yesterday' ,'month','previous_month', 'year', 'previous_year', 'sales', 'today_expenses', 'yesterday_expenses', 'month_expenses', 'previous_month_expenses', 'year_expenses', 'previous_year_expenses', 'expenses', 'current_sales', 'current_expenses', 'today_profit', 'month_profit', 'year_profit', 'yesterday_profit', 'previous_month_profit', 'previous_year_profit'));
    }
}
