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
}
