<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
class Order extends Model
{
    use Notifiable;
    public function tarif()
    {
        return $this->belongsTo('App\Tarif');
    }

    public function automobile()
    {
        return $this->belongsTo('App\Automobile', 'car_id');
    }

    public function operator()
    {
        return $this->belongsTo('App\Operator', 'operator_id');
    }
    public function getCarName(){
        return $this->automobile->name;
    }
    public function getTarifName(){
        return $this->tarif->type;
    }
    public function tarifName(){
        return $this->tarif->type == 0 ? 'Внутри города' : 'За городом';
    }
}
