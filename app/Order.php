<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function tarif()
    {
        return $this->belongsTo('App\Tarif');
    }

    public function automobile()
    {
        return $this->belongsTo('App\Automobile', 'car_id');
    }
}
