<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->integer('open_stock');
            $table->float('unit_price');
            $table->integer('profit');
            $table->integer('qty')->nullable();
            $table->float('total_amount');
            $table->enum('payment_type', ['Cash', 'Transfer', 'Credit', 'exchange']);
            $table->unsignedBigInteger('exchangein_id')->nullable();
            $table->unsignedBigInteger('exchangeout_id')->nullable();
            $table->unsignedBigInteger('launch_id')->nullable();
            $table->integer('closing_stock');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('exchangein_id')->references('id')->on('exchangeins')->onDelete('cascade');
            $table->foreign('exchangeout_id')->references('id')->on('exchangeouts')->onDelete('cascade');
            $table->foreign('launch_id')->references('id')->on('launches')->onDelete('cascade');
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
        Schema::dropIfExists('sales');
    }
}
