<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Automobile extends Model
{
    public function order(){
        return $this->hasOne('App\Order');
    }
}