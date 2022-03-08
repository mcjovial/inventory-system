<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExchangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exchanges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('exchangein_id');
            $table->unsignedBigInteger('exchangeout_id');
            $table->integer('debt');

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('exchangein_id')->references('id')->on('exchangeins')->onDelete('cascade');
            $table->foreign('exchangeout_id')->references('id')->on('exchangeouts')->onDelete('cascade');

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
        Schema::dropIfExists('exchanges');
    }
}
