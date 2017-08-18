<?php

namespace App\Http\Controllers;

use App\Order;
use App\TaxiOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Automobile;
use App\Tarif;
use App\TaxiTarif;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class OperatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public static $sort = null;

    public function __construct()
    {
        $this->middleware('auth:operator');
    }

    public function index()
    {
        $automobiles = Automobile::all();
        $automobile = array();
        $tariffs = Tarif::all();
        $tariff = array();


        $taxi_tariff = TaxiTarif::first();
        $orders = Order::where('status', '!=', 0)->paginate(6,['*'],'orders');
        $orders_wait = Order::where('status', 0)->get();

        $taxi_orders = TaxiOrder::where('status', '!=', 0)->paginate(6,['*'],'taxi_orders');
        $taxi_orders_wait = TaxiOrder::where('status', 0)->get();

        foreach ($automobiles as $key)
            $automobile[$key->id] = $key->name;
        foreach ($tariffs as $tr)
            if ($tr->type == 0)
                $tariff[$tr->id] = "Внутри города";
            else
                $tariff[$tr->id] = "За городом";

        /** @noinspection PhpUndefinedMethodInspection */
        return view('operator')
            ->withTariffs($tariffs)
            ->withTariff($tariff)
            ->withTaxi_tariff($taxi_tariff)
            ->withAutomobiles($automobiles)
            ->withAutomobile($automobile)
            ->withOrders_wait($orders_wait)
            ->withOrders($orders)
            ->withTaxi_orders_wait($taxi_orders_wait)
            ->withTaxi_orders($taxi_orders);
    }

    public function orderSubmit(Request $request)
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

        $order = new Order;
        $order->user_type = 2;
        $order->user_id = Auth::guard('operator')->user()->id;

        $order->tarif_id = $request->tariff_id;
        $order->car_id = $request->automobile_id;

        $order->persons = $request->loaders;
        $tarif = Tarif::findOrFail($request->tariff_id);
        if ($tarif->type == 0)
            $order->unit = $request->hour;
        else
            $order->unit = $request->distance;

        $order->address_A = $request->address_a;
        $order->address_B = $request->address_b;
        $order->point_A = $request->point_a;
        $order->point_B = $request->point_b;
        $order->start_time = date('Y-m-d H:i:s', strtotime($request->start));

        $order->name = $request->name;
        $order->phone = $request->phone;
        $order->sum = $request->price;
        $order->status = 1;
        $order->operator_id = Auth::guard('operator')->user()->id;

        $order->save();
        /** @noinspection PhpUndefinedMethodInspection */
        Session::flash('message', 'Ваш заказ успешно создано');
        return redirect()->back();
    }

    public function orderAccept(Request $request, $order_id, $operator_id)
    {
        $order = Order::find($order_id);
        $order->operator_id = $operator_id;
        $order->status = 1;
        $order->save();
        return redirect()->back();
    }

    public function orderRefuse(Request $request, $order_id, $operator_id)
    {
        $order = Order::find($order_id);
        $order->operator_id = $operator_id;
        $order->status = -1;
        $order->save();
        return redirect()->back();
    }

    public function orderDelete(Request $request, $order_id)
    {
        $order = Order::find($order_id);
        $order->delete();

        return redirect()->route('operator.dashboard');
    }

    public function orderUpdate($id)
    {
        $order = Order::findOrFail($id);

        $automobiles = Automobile::all();
        $automobile = array();
        foreach ($automobiles as $key) {
            $automobile[$key->id] = $key->name;
        }

        $tariffs = Tarif::all();
        $tariff = array();

        foreach ($tariffs as $tr) {
            if ($tr->type == 0)
                $tariff[$tr->id] = "Внутри города";
            else
                $tariff[$tr->id] = "За городом";
        }

        /** @noinspection PhpUndefinedMethodInspection */
        return view('operator.order')
            ->withOrder($order)
            ->withTariffs($tariffs)
            ->withTariff($tariff)
            ->withAutomobiles($automobiles)
            ->withAutomobile($automobile);
    }

    public function orderUpdateSubmit(Request $request, $id)
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

        $order = Order::findOrFail($id);
        $order->user_type = 2;
        $order->user_id = Auth::guard('operator')->user()->id;

        $order->tarif_id = $request->tariff_id;
        $order->car_id = $request->automobile_id;

        $order->persons = $request->loaders;
        $tariff = Tarif::findOrFail($request->tariff_id);
        if ($tariff->type == 0)
            $order->unit = $request->hour;
        else
            $order->unit = $request->distance;

        $order->address_A = $request->address_a;
        $order->address_B = $request->address_b;
        $order->point_A = $request->point_a;
        $order->point_B = $request->point_b;
        $order->start_time = date('Y-m-d H:i:s', strtotime($request->start));

        $order->name = $request->name;
        $order->phone = $request->phone;
        $order->sum = $request->price;
        $order->status = 0;
        $order->operator_id = Auth::guard('operator')->user()->id;
        $order->save();

        return redirect()->route('operator.dashboard');
    }

    public function orderRestore(Request $request, $id)
    {
        $order = Order::find($id);
        $order->status = 0;
        $order->operator_id = null;
        $order->save();

        return redirect()->route('operator.dashboard');
    }

    public function search(Request $request)
    {
        $cars = Automobile::all();
        $car = array();
        foreach ($cars as $key) {
            $car[$key->id] = $key->name;
        }
        $tariffs = Tarif::all();
        $tariff = array();
        foreach ($tariffs as $tr) {
            if ($tr->type == 0)
                $tariff[$tr->id] = "Внутри города";
            else
                $tariff[$tr->id] = "За городом";
        }
        $orders_wait = Order::where('status', 0)->get();
        $orders = Order::where('status', '!=', 0);

        $taxi_tariff = TaxiTarif::first();
        $taxi_orders = TaxiOrder::where('status', '!=', 0)->paginate(6,['*'],'taxi_orders');

        $taxi_orders_wait = TaxiOrder::where('status', 0)->get();

        if ($request->search != null || $request->search == "") {
            if (substr($request->search, 0, 1) == "#") {
                $orders = Order::where('status', '!=', 0)->where('id', ltrim($request->search, '#'));
            } else {
                $orders = Order::where('status', '!=', 0)->where(function ($query) use ($request) {
                    /** @noinspection PhpUndefinedMethodInspection */
                    $query->orWhere('id', $request->search)
                        ->with('automobile')->whereHas('automobile', function ($query) use ($request) {
                            /** @noinspection PhpUndefinedMethodInspection */
                            $query->where('name', 'LIKE', "%$request->search%");
                        })
                        ->orWhere('name', 'LIKE', "%$request->search%")
                        ->orWhere('sum', 'LIKE', "%$request->search%")
                        ->orWhere('address_A', 'LIKE', "%$request->search%")
                        ->orWhere('address_B', 'LIKE', "%$request->search%")
                        ->orWhere('phone', 'LIKE', "%$request->search%");
                });
            }

        }
        if ($request->filter == "name") {
            /** @noinspection PhpUndefinedMethodInspection */
            if (Session::get('sort')) {
                $orders = $orders
                    ->orderBy('name', 'desc');
                /** @noinspection PhpUndefinedMethodInspection */
                Session::put('sort', false);
            } else {
                $orders = $orders
                    ->orderBy('name', 'asc');
                /** @noinspection PhpUndefinedMethodInspection */
                Session::put('sort', true);
            }
        }
        if ($request->filter == "sum") {
            /** @noinspection PhpUndefinedMethodInspection */
            if (Session::get('sort')) {
                $orders = $orders
                    ->orderBy('sum', 'desc');
                /** @noinspection PhpUndefinedMethodInspection */
                Session::put('sort', false);
            } else {
                $orders = $orders
                    ->orderBy('sum', 'asc');
                /** @noinspection PhpUndefinedMethodInspection */
                Session::put('sort', true);
            }
        }
        if ($request->filter == "id") {

            /** @noinspection PhpUndefinedMethodInspection */
            if (Session::get('sort')) {
                $orders = $orders
                    ->orderBy('id', 'desc');
                /** @noinspection PhpUndefinedMethodInspection */
                Session::put('sort', false);
            } else {
                $orders = $orders
                    ->orderBy('id', 'asc');
                /** @noinspection PhpUndefinedMethodInspection */
                Session::put('sort', true);
            }
        }
        if ($request->filter == "date") {

            /** @noinspection PhpUndefinedMethodInspection */
            if (Session::get('sort')) {
                $orders = $orders
                    ->orderBy('start_time', 'desc');
                /** @noinspection PhpUndefinedMethodInspection */
                Session::put('sort', false);
            } else {
                $orders = $orders
                    ->orderBy('start_time', 'asc');
                /** @noinspection PhpUndefinedMethodInspection */
                Session::put('sort', true);
            }
        }
        $orders = $orders->paginate(6,['*'],'orders');

        /** @noinspection PhpUndefinedMethodInspection */
        return view('operator')
            ->withTariffs($tariffs)
            ->withTariff($tariff)
            ->withAutomobiles($cars)
            ->withAutomobile($car)
            ->withOrders($orders)
            ->withOrders_wait($orders_wait)
            ->with('taxi_tariff', $taxi_tariff)
            ->withTaxi_orders_wait($taxi_orders_wait)
            ->withTaxi_orders($taxi_orders);
    }


    public function taxiOrderSubmit(Request $request)
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
        $order->user_type = 2;
        $order->user_id = Auth::guard('operator')->user()->id;
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
        $order->operator_id = Auth::guard('operator')->user()->id;

        $order->save();
        /** @noinspection PhpUndefinedMethodInspection */
        Session::flash('message', 'Ваш заказ успешно создано');
        return redirect()->back();
    }

    public function taxiOrderAccept(Request $request, $taxi_order_id, $operator_id)
    {
        $order = TaxiOrder::find($taxi_order_id);
        $order->operator_id = $operator_id;
        $order->status = 1;
        $order->save();
        return redirect()->back();
    }

    public function taxiOrderRefuse(Request $request, $taxi_order_id, $operator_id)
    {
        $order = TaxiOrder::find($taxi_order_id);
        $order->operator_id = $operator_id;
        $order->status = -1;
        $order->save();
        return redirect()->back();
    }

    public function taxiOrderDelete(Request $request, $taxi_order_id)
    {
        $order = TaxiOrder::find($taxi_order_id);
        $order->delete();
        return redirect()->route('operator.dashboard');
    }

    public function taxiOrderUpdate($id)
    {
        $taxi_order = TaxiOrder::findOrFail($id);
        $taxi_tariff = TaxiTarif::first();

        /** @noinspection PhpUndefinedMethodInspection */
        return view('operator.taxi_order')
            ->withOrder($taxi_order)
            ->withTaxi_tariff($taxi_tariff);
    }

    public function taxiOrderUpdateSubmit(Request $request, $id)
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

        $order = TaxiOrder::findOrFail($id);

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
        $order->save();

        /** @noinspection PhpUndefinedMethodInspection */
        Session::flash('message', 'Заказ изменен');
        return redirect()->route('operator.dashboard');
    }

    public function taxiOrderRestore(Request $request, $id)
    {
        $order = TaxiOrder::find($id);
        $order->status = 0;
        $order->operator_id = null;
        $order->save();
        return redirect()->route('operator.dashboard');
    }

    public function taxiSearch(Request $request)
    {
        $taxi_tariff = TaxiTarif::first();
        $orders_main = Order::where('status', '!=', 0)->paginate(6,['*'],'orders');
        $orders_wait = Order::where('status', 0)->get();

        $orders = TaxiOrder::where('status', '!=', 0);
        $taxi_orders_wait = TaxiOrder::where('status', 0)->get();

        $cars = Automobile::all();
        $car = array();
        foreach ($cars as $key) {
            $car[$key->id] = $key->name;
        }

        $tariffs = Tarif::all();
        $tariff = array();
        foreach ($tariffs as $tr) {
            if ($tr->type == 0)
                $tariff[$tr->id] = "Внутри города";
            else
                $tariff[$tr->id] = "За городом";
        }


        if ($request->search != null || $request->search == "") {
            if (substr($request->search, 0, 1) == "#") {
                $orders = TaxiOrder::where('status', '!=', 0)->where('id', ltrim($request->search, '#'));
            } else {
                $orders = TaxiOrder::where('status', '!=', 0)
                    ->where(function ($query) use ($request) {
                        /** @noinspection PhpUndefinedMethodInspection */
                        $query->orWhere('id', $request->search)
                            ->orWhere('name', 'LIKE', "%$request->search%")
                            ->orWhere('price', 'LIKE', "%$request->search%")
                            ->orWhere('address_A', 'LIKE', "%$request->search%")
                            ->orWhere('address_B', 'LIKE', "%$request->search%")
                            ->orWhere('phone', 'LIKE', "%$request->search%");
                    });
            }
        }
        if ($request->filter == "name") {
            /** @noinspection PhpUndefinedMethodInspection */
            if (Session::get('sort_taxi')) {
                $orders = $orders
                    ->orderBy('name', 'desc');
                /** @noinspection PhpUndefinedMethodInspection */
                Session::put('sort_taxi', false);
            } else {
                $orders = $orders
                    ->orderBy('name', 'asc');
                /** @noinspection PhpUndefinedMethodInspection */
                Session::put('sort_taxi', true);
            }
        }
        if ($request->filter == "sum") {
            /** @noinspection PhpUndefinedMethodInspection */
            if (Session::get('sort_taxi')) {
                $orders = $orders
                    ->orderBy('price', 'desc');
                /** @noinspection PhpUndefinedMethodInspection */
                Session::put('sort_taxi', false);
            } else {
                $orders = $orders
                    ->orderBy('price', 'asc');
                /** @noinspection PhpUndefinedMethodInspection */
                Session::put('sort_taxi', true);
            }
        }
        if ($request->filter == "id") {

            /** @noinspection PhpUndefinedMethodInspection */
            if (Session::get('sort_taxi')) {
                $orders = $orders
                    ->orderBy('id', 'desc');
                /** @noinspection PhpUndefinedMethodInspection */
                Session::put('sort_taxi', false);
            } else {
                $orders = $orders
                    ->orderBy('id', 'asc');
                /** @noinspection PhpUndefinedMethodInspection */
                Session::put('sort_taxi', true);
            }
        }
        if ($request->filter == "date") {

            /** @noinspection PhpUndefinedMethodInspection */
            if (Session::get('sort_taxi')) {
                $orders = $orders
                    ->orderBy('start_time', 'desc');
                /** @noinspection PhpUndefinedMethodInspection */
                Session::put('sort_taxi', false);
            } else {
                $orders = $orders
                    ->orderBy('start_time', 'asc');
                /** @noinspection PhpUndefinedMethodInspection */
                Session::put('sort_taxi', true);
            }
        }
        $orders = $orders->paginate(6,['*'],'taxi_orders');

        /** @noinspection PhpUndefinedMethodInspection */
        return view('operator')
            ->withTariffs($tariffs)
            ->withTariff($tariff)
            ->withAutomobiles($cars)
            ->withAutomobile($car)
            ->withOrders($orders_main)
            ->withOrders_wait($orders_wait)
            ->with('taxi_tariff', $taxi_tariff)
            ->withTaxi_orders_wait($taxi_orders_wait)
            ->withTaxi_orders($orders);
    }
}
