<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sur_name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('other_name')->nullable();
            $table->string('full_name')->nullable();
            $table->string('b_month')->nullable();
            $table->integer('b_day')->nullable();
            $table->string('email')->nullable();
            $table->integer('phone')->nullable();
            $table->string('pow')->nullable();
            $table->string('address')->nullable();
            $table->string('type')->nullable();
            $table->string('state')->nullable();
            $table->boolean('status')->nullable();
            $table->integer('debt')->nullable();
            $table->integer('reg_fee')->nullable();
            $table->string('photo')->nullable();
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
        Schema::dropIfExists('customers');
    }
}
