<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('customer_name')->nullable();
            $table->integer('customer_phone')->nullable();
            $table->string('order_date');
            $table->string('order_status');
            $table->integer('total_products');
            $table->integer('total_cost');
            $table->float('sub_total');
            $table->float('vat');
            $table->float('total');
            $table->boolean('launch')->default(false);
            $table->boolean('owing');
            $table->boolean('to_balance');
            $table->string('payment_status');
            $table->float('pay')->nullable();
            $table->float('debt')->nullable();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
