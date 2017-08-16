<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaxiOrder extends Model
{
    protected $table = 'taxiorder';

    public function tarif()
    {
        return $this->belongsTo('App\TaxiTarif');
    }
}
