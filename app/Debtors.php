<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Debtors extends Model
{
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

}
