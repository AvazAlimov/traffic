<?php

namespace App;


use Illuminate\Foundation\Auth\User as Authenticatable;

class Operator extends Authenticatable
{

    protected $guard = 'operator';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'name', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function order(){
        return $this->hasMany('App\Order');
    }
    public function taxiorder(){
        return $this->hasMany('App\TaxiOrder');
    }
}
