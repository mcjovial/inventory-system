<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supply extends Model
{
    public function drink()
    {
        return $this->belongsTo(Product::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
