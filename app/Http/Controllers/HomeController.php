<?php

namespace App\Http\Controllers;

use App\Notifications\OrderNotification;
use App\Notifications\TaxiOrderNotification;
use App\TaxiOrder;
use App\TaxiTarif;
use Illuminate\Http\Request;
use App\Tarif;
use App\Automobile;
use App\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class HomeController extends Controller
{
    /** @noinspection PhpDocSignatureInspection */
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
        $orders = Order::where('user_type', 1)
            ->where('user_id', Auth::user()->id)
            ->orderBy('id', 'desc')
            ->paginate(6, ['*'], 'orders');
        $taxi_orders = TaxiOrder::where('user_type', 1)
            ->where('user_id', Auth::user()->id)
            ->orderBy('id', 'desc')
            ->paginate(6, ['*'], 'taxi_orders');

        $tariffs = Tarif::all();
        $tariff = array();
        foreach ($tariffs as $tr) {
            if ($tr->type == 0)
                $tariff[$tr->id] = "Внутри города";
            else
                $tariff[$tr->id] = "За городом";
        }

        $cars = Automobile::all();
        $car = array();

        foreach ($cars as $key) {
            $car[$key->id] = $key->name;
        }

        $taxi_tariff = TaxiTarif::first();
        return view('home')
            ->withTariff($tariff)
            ->withTariffs($tariffs)
            ->withAutomobile($car)
            ->withAutomobiles($cars)
            ->withTaxi_tariff($taxi_tariff)
            ->withOrders($orders)
            ->withTaxi_orders($taxi_orders);
    }

    public function orderSubmit(Request $request)
    {
        $rules = [
            'name' => 'required',
            'phone' => 'required',
            'address_A' => 'required',
            'address_B' => 'required',
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
        $order->notify(new OrderNotification());
        return redirect()->route('home');
    }

    public function orderAgain($id)
    {
        $order = Order::findOrFail($id);

        $tariffs = Tarif::all();
        $tariff = array();

        foreach ($tariffs as $tr) {
            if ($tr->type == 0)
                $tariff[$tr->id] = "Внутри города";
            else
                $tariff[$tr->id] = "За городом";
        }

        $cars = Automobile::all();
        $car = array();
        foreach ($cars as $key) {
            $car[$key->id] = $key->name;
        }

        return view('user.order-again')
            ->withTariff($tariff)
            ->withTariffs($tariffs)
            ->withAutomobile($car)
            ->withAutomobiles($cars)
            ->withTarif($tariff)
            ->withCar($car)
            ->withTarifs($tariffs)
            ->withCars($cars)
            ->withOrder($order);

    }

    public function taxiorderSubmit(Request $request)
    {
        $rules = [
            'name' => 'required',
            'phone' => 'required',
            'address_a' => 'required',
            'address_b' => 'required',
            'point_a' => 'required',
            'point_b' => 'required',
        ];

        $messages = [
            'point_a.required' => 'Пункт А не выбран',
            'point_b.required' => 'Пункт Б не выбран',
            'name.required' => 'Введите имя',
            'phone.required' => 'Введите телефон',
        ];

        /** @noinspection PhpUndefinedMethodInspection */
        Validator::make($request->all(), $rules, $messages)->validate();

        $order = new TaxiOrder;
        $order->user_type = 1;
        $order->user_id = Auth::user()->id;
        $order->tarif_id = TaxiTarif::first()->id;

        $order->minute = $request->minute;
        $order->distance = $request->distance;

        $order->address_A = $request->address_a;
        $order->address_B = $request->address_b;
        $order->point_A = $request->point_a;
        $order->point_B = $request->point_b;

        $order->start_time = date('Y-m-d H:i:s', strtotime($request->start));

        $order->name = $request->name;
        $order->phone = $request->phone;
        $order->price = $request->price;
        $order->status = 1;

        $order->save();
        $order->notify(new TaxiOrderNotification());
        return redirect()->route('home');
    }

    public function taxiOrderAgain($id)
    {
        $order = TaxiOrder::findOrFail($id);
        $tariff = TaxiTarif::first();

        return view('user.taxi-order-again')->withTarif($tariff)->withOrder($order);

    }
}
