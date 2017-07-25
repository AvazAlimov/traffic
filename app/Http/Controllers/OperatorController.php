<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Automobile;
use App\Tarif;

class OperatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */

    public function __construct()
    {
       $this->middleware('auth:operator');
    }

    public function index()
    {
        return view('operator');
    }
    public function createOrder(){
        $cars = Automobile::all();
        $tarifs = Tarif::all();
        return view('operator.order')->withCars($cars)->withTarifs($tarifs);
    }
}
