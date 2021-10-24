<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


// Admin Group
Route::group(['as'=>'admin.', 'prefix' => 'admin', 'middleware' => 'auth' ], function(){
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::resource('employee', 'EmployeeController');
    Route::resource('customer', 'CustomerController');
    Route::resource('attendance', 'AttendanceController');
    Route::put('attendance/{attendance?}', 'AttendanceController@att_update')->name('attendance.att_update');
    Route::resource('supplier', 'SupplierController');
    Route::resource('supply', 'SupplyController');
    Route::resource('advanced_salary', 'AdvancedSalaryController');
    Route::resource('sale', 'SalesController');
    Route::resource('salary', 'SalaryController');
    Route::resource('category', 'CategoryController');
    Route::resource('product', 'ProductController');
    Route::resource('expense', 'ExpenseController');
    Route::resource('dues', 'DuesController');
    Route::resource('sales', 'SalesController');

    Route::get('exchange', 'ExchangeController@create')->name('exchange.create');
    Route::post('exchange/store', 'ExchangeController@store')->name('exchange.store');
    Route::post('exchange/{id}', 'ExchangeController@update')->name('exchange.update');
    Route::post('exchange', 'ExchangeController@final_invoice')->name('exchange.invoice');

    Route::get('launch', 'LaunchController@create')->name('launch.create');
    Route::post('launch/store', 'LaunchController@store')->name('launch.store');
    Route::post('launch/cart/{id}', 'LaunchController@cart_update')->name('launch.cart_update');
    Route::post('launch', 'LaunchController@final_invoice')->name('launch.invoice');
    Route::post('launch/cart-store', 'LaunchController@cart_store')->name('launch.cart_store');

    Route::get('order/balance', 'BalanceController@index')->name('balance.index');
    Route::get('order/balance/{id}', 'BalanceController@create')->name('order.create_balance');
    Route::get('order/balance/{id}/edit', 'BalanceController@edit')->name('balance.edit');
    Route::post('order/balance/{id}/update', 'BalanceController@update')->name('balance.update');
    Route::get('order/balance/{id}/destroy', 'BalanceController@destroy')->name('balance.destroy');
    Route::post('order/balance/{id}', 'OrderController@balance')->name('order.balance');

    Route::get('expense-today', 'ExpenseController@today_expense')->name('expense.today');
    Route::get('expense-month/{month?}', 'ExpenseController@month_expense')->name('expense.month');
    Route::get('expense-yearly/{year?}', 'ExpenseController@yearly_expense')->name('expense.yearly');

    Route::get('setting', 'SettingController@index')->name('setting.index');
    Route::put('setting/{id}', 'SettingController@update')->name('setting.update');

    Route::resource('pos', 'PosController');

    Route::get('order/show/{id}', 'OrderController@show')->name('order.show');
    Route::get('order/pending', 'OrderController@pending_order')->name('order.pending');
    Route::get('order/approved', 'OrderController@approved_order')->name('order.approved');
    Route::get('order/confirm/{id}', 'OrderController@order_confirm')->name('order.confirm');
    Route::get('order/credit', 'OrderController@credit_order')->name('order.credit');
    Route::get('order/to-balance', 'OrderController@to_balance')->name('order.to_balance');
    Route::delete('order/delete/{id}', 'OrderController@destroy')->name('order.destroy');
    Route::get('order/download/{id}', 'OrderController@download')->name('order.download');

    Route::get('order/balance', 'BalanceController@index')->name('balance.index');
    Route::get('order/balance/{id}', 'BalanceController@create')->name('order.create_balance');
    Route::get('order/balance/{id}/edit', 'BalanceController@edit')->name('balance.edit');
    Route::post('order/balance/{id}/update', 'BalanceController@update')->name('balance.update');
    Route::get('order/balance/{id}/destroy', 'BalanceController@destroy')->name('balance.destroy');
    Route::post('order/balance/{id}', 'OrderController@balance')->name('order.balance');

    Route::get('sales-today', 'OrderController@today_sales')->name('sales.today');
    Route::get('sales-monthly/{month?}', 'OrderController@monthly_sales')->name('sales.monthly');
    Route::get('sales-total','OrderController@total_sales')->name('sales.total');

    Route::resource('cart', 'CartController');

    Route::post('invoice', 'InvoiceController@create')->name('invoice.create');
    // Route::get('print/{customer_id}', 'InvoiceController@print')->name('invoice.print');
    Route::post('print', 'InvoiceController@print')->name('invoice.print');
    Route::get('order-print/{order_id}', 'InvoiceController@order_print')->name('invoice.order_print');
    Route::post('invoice-final', 'InvoiceController@final_invoice')->name('invoice.final_invoice');

});
