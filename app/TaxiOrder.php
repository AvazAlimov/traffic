<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class TaxiOrder extends Model
{
    use Notifiable;
    protected $table = 'taxiorder';

    public function tarif()
    {
        return $this->belongsTo('App\TaxiTarif');
    }
}
