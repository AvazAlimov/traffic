<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tarif;
use App\Automobile;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tarifs = Tarif::all();
        $tarif = array();

        foreach ($tarifs as $tr) {
            if ($tr->type == 0)
                $tarif[$tr->id] = "Внутри города";
            else
                $tarif[$tr->id] = "За городом";
        }

        $cars = Automobile::all();
        $car = array();
        foreach ($cars as $key) {
            $car[$key->id] = $key->name;
        }

        return view('home')->withTarif($tarif)->withCar($car)->withTarifs($tarifs)->withCars($cars);
    }
}
