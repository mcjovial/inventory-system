<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function debts()
    {
        return $this->hasMany(Debtors::class);
    }

    public function dues()
    {
        return $this->hasMany(Dues::class);
    }
}
