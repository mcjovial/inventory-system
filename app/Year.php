<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    public function dues()
    {
        return $this->hasMany(Dues::class);
    }

}
