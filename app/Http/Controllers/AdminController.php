<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\AdminResetPasswordNotification;
use Illuminate\Support\Facades\DB;
use App\Tarif;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $automobiles = DB::table('automobiles')->get();
        $operators = DB::table('operators')->get();
        $tarifs = DB::table('tarifs')->get();
        return view('admin')->with('automobiles', $automobiles)->with('operators', $operators)->with('tarifs', $tarifs);
    }
    public function updateTarif(Request $request, $id)
    {
        $tarif = Tarif::find($id);

        if($tarif->type == 0){
            $tarif->price_per_hour = $request->price_per_hour;
            $tarif->min_hour = $request->min_hour;
        }
        else
        {
            $tarif->price_per_distance = $request->price_per_distance;
            $tarif->min_distance = $request->min_distance;
        }

        $tarif->price_minimum =$request->price_minimum;
        $tarif->price_per_person =$request->price_per_person;
        $tarif->discard = $request->discard;
        $tarif->save();

        return redirect()->back();
    }
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPasswordNotification($token));
    }
}
