<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tarif;
use App\Automobile;
use App\Order;
use Auth;
use Validator;
use Carbon\Carbon;

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
        $orders = Order::where('user_type',1)->where('user_id',Auth::user()->id)->orderBy('id', 'desc')->paginate(4);

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

        return view('home')->withTarif($tarif)->withCar($car)->withTarifs($tarifs)->withCars($cars)->withOrders($orders);
    }
    public function orderSubmit(Request $request){
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
        $order->user_type = 1;
        $order->user_id = Auth::user()->id;
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
        $order->status = 0;
        $order->start_time = Carbon::parse($request->date . " " . $request->time, null);
        $order->save();
        return redirect()->route('home');
    }

    public function orderAgain(Request $request, $id)
    {
        $order = Order::findOrFail($id);

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

        return view('user.order-again')->withTarif($tarif)->withCar($car)->withTarifs($tarifs)->withCars($cars);

    }
}
