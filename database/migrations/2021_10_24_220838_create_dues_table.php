<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dues', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('customer_id');
            $table->integer('year');
            $table->integer('reg_fee')->nullable();
            $table->dateTime('reg_fee_date')->nullable();
            $table->integer('annual')->nullable();
            $table->dateTime('annual_date')->nullable();
            $table->integer('welfare')->nullable();
            $table->dateTime('welfare_date')->nullable();
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
        Schema::dropIfExists('dues');
    }
}
