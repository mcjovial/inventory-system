<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dues extends Model
{
    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function year()
    {
        return $this->belongsTo(Year::class);
    }
}
