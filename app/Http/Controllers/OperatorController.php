<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
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
        $car =array();
        foreach ($cars as $key) {
            $car[$key->id]= $key->name;
        }

        $tarifs = Tarif::all();
       $tarif = array();
        foreach ($tarifs as $tr) {
            if($tr->type == 0)
                $tarif[$tr->id] = "Inside";
            else
                $tarif[$tr->id] = "Outside";
        }



        return view('operator.order')->withCars($cars)->withTarifs($tarifs)->withCar($car)->withTarif($tarif);
    }
    public function orderSubmit(Request $request){


    }
}
