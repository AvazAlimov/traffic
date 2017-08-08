<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Tarif;
use App\Order;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $automobiles = DB::table('automobiles')->get();
        $operators = DB::table('operators')->get();
        $tariffs = DB::table('tarifs')->get();
        $orders = Order::where('status', '!=', 0);

        return view('admin')
            ->with('automobiles', $automobiles)
            ->with('operators', $operators)
            ->with('tarifs', $tariffs)
            ->with('orders', $orders);
    }

    public function updateTarif(Request $request, $id)
    {
        $tariff = Tarif::find($id);

        if ($tariff->type == 0) {
            $tariff->price_per_hour = $request->price_per_hour;
            $tariff->min_hour = $request->min_hour;
        } else {
            $tariff->price_per_distance = $request->price_per_distance;
            $tariff->min_distance = $request->min_distance;
        }

        $tariff->price_minimum = $request->price_minimum;
        $tariff->price_per_person = $request->price_per_person;
        $tariff->discard = $request->discard;
        $tariff->save();

        return redirect()->back();
    }
}
