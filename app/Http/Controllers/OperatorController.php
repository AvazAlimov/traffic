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
        $cars = Automobile::all();
        $car = array();
        foreach ($cars as $key) {
            $car[$key->id] = $key->name;
        }

        $tarifs = Tarif::all();
        $tarif = array();

        foreach ($tarifs as $tr) {
            if ($tr->type == 0)
                $tarif[$tr->id] = "Внутри города";
            else
                $tarif[$tr->id] = "За городом";
        }

        $orders = Order::all();

        return view('operator')->withCars($cars)->withTarifs($tarifs)->withCar($car)->withTarif($tarif)->withOrders($orders);
    }

    public function orderSubmit(Request $request)
    {
        $rules = [
            'name' => 'required',
            'phone' => 'required',

            'point_A' => 'required',
            'point_B' => 'required',
        ];

        $messages = [
            'point_A.required' => 'Пункт А не выбран',
            'point_B.required' => 'Пункт Б не выбран',
            'name.required' => 'Введите имя',
            'phone.required' => 'Введите телефон',
        ];

        Validator::make($request->all(), $rules, $messages)->validate();

        $order = new Order;
        $order->user_type = 2;
        $order->user_id = Auth::guard('operator')->user()->id;
        $order->car_id = $request->car;
        $order->tarif_id = $request->tarif;
        $order->address_A = $request->address_A;
        $order->address_B = $request->address_B;
        $order->point_A = $request->point_A;
        $order->point_B = $request->point_B;
        $order->persons = $request->persons;
        $order->unit = $request->unit;
        $order->name = $request->name;
        $order->phone = $request->phone;
        $order->sum = $request->sum;
        $order->status = 1;
        $order->start_time = Carbon::parse($request->date . " " . $request->time, null);
        $order->save();
        return redirect()->route('operator.dashboard');
    }

    public function orderAccept(Request $request, $order_id, $operator_id)
    {
        $order = Order::find($order_id);
        $order->operator_id = $operator_id;
        $order->status = 1;
        $order->save();
        return redirect()->route('operator.dashboard');
    }

    public function orderRefuse(Request $request, $order_id, $operator_id)
    {
        $order = Order::find($order_id);
        $order->operator_id = $operator_id;
        $order->status = -1;
        $order->save();
        return redirect()->route('operator.dashboard');
    }

    public function orderDelete(Request $request, $order_id, $operator_id)
    {
        $order = Order::find($order_id);
        $order->delete();
        return redirect()->route('operator.dashboard');
    }
    public function orderUpdate($id){
        $order = Order::findOrFail($id);

        $cars = Automobile::all();
        $car = array();
        foreach ($cars as $key) {
            $car[$key->id] = $key->name;
        }

        $tarifs = Tarif::all();
        $tarif = array();

        foreach ($tarifs as $tr) {
            if ($tr->type == 0)
                $tarif[$tr->id] = "Внутри города";
            else
                $tarif[$tr->id] = "За городом";
        }


        return view('operator.order')->withOrder($order)->withCars($cars)->withTarifs($tarifs)->withCar($car)->withTarif($tarif);
    }
    public function orderUpdateSubmit(Request $request, $id){
        $rules = [
            'name' => 'required',
            'phone' => 'required',

            'point_A' => 'required',
            'point_B' => 'required',
        ];

        $messages = [
            'point_A.required' => 'Пункт А не выбран',
            'point_B.required' => 'Пункт Б не выбран',
            'name.required' => 'Введите имя',
            'phone.required' => 'Введите телефон',
        ];

        Validator::make($request->all(), $rules, $messages)->validate();

        $order = Order::findOrFail($id);
        $order->car_id = $request->car;
        $order->tarif_id = $request->tarif;
        $order->address_A = $request->address_A;
        $order->address_B = $request->address_B;
        $order->point_A = $request->point_A;
        $order->point_B = $request->point_B;
        $order->persons = $request->persons;
        $order->unit = $request->unit;
        $order->name = $request->name;
        $order->phone = $request->phone;
        $order->sum = $request->sum;
        $order->start_time = Carbon::parse($request->date . " " . $request->time, null);
        $order->save();
        return redirect()->route('operator.dashboard');
    }
}
