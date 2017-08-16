<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaxiTarif extends Model
{
    protected $table = 'taxitarif';
    public function order(){
        return $this->hasOne('App\TaxiOrder');
    }
}
