<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flat extends Model
{
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function drink()
    {
        return $this->belongsTo(Product::class);
    }
}
