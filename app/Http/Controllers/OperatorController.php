<?php

namespace App\Http\Controllers;
use App\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Automobile;
use App\Tarif;
use Validator;
use Auth;
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
        $rules = [
            'name' => 'required',
            'phone'=>'required',

            'point_A' => 'required',
            'point_B' => 'required',
        ];
        $messages = [
            'point_A.required' => 'Пункт А не выбран',
            'point_B.required' => 'Пункт Б не выбран',
            'name.required' => 'Введите имя',
            'phone.required'=> 'Введите телефон',
        ];
        Validator::make($request->all(), $rules, $messages)->validate();
            $order = new Order;
            $order->user_type = 2;
            $order->user_id = Auth::guard('operator')->user()->id;
            $order->car_id = $request->car;
            $order->tarif_id = $request->tarif;
            $order->address_A= $request->address_A;
            $order->address_B= $request->address_B;
            $order->point_A =$request->point_A;
            $order->point_B= $request->point_B;
            $order->persons = $request->persons;
            $order->unit = $request->unit;
            $order->name =$request->name;
            $order->phone =$request->phone;
            $order->sum = $request->sum;
            $order->status = 1;
            $order->start_time = Carbon::parse($request->date." ".$request->time, new \DateTimeZone('Asia/Tashkent'));
            $order->save();

    }
}
