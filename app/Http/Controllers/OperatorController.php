<?php

namespace App\Http\Controllers;

use App\Order;
use Carbon\Carbon;
use function foo\func;
use Illuminate\Http\Request;
use App\Automobile;
use App\Tarif;
use Illuminate\Support\Facades\Session;
use Validator;
use Auth;

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

        $orders = Order::where('status', '!=', 0)->paginate(6);
        $orders_wait = Order::where('status', 0)->paginate(8);
        return view('operator')->withCars($cars)->withTarifs($tarifs)->withCar($car)->withTarif($tarif)->withOrders($orders)->withOrders_wait($orders_wait)->withSection(2);

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
        return redirect()->back();
    }

    public function orderUpdate($id)
    {
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


        return view('operator.order')->withOrder($order)->withCars($cars)->withTarifs($tarifs)->withCar($car)->withTarif($tarif)->withSection(1);
    }

    public function orderUpdateSubmit(Request $request, $id)
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

        $tarifs = Tarif::all();
        $tarif = array();

        foreach ($tarifs as $tr) {
            if ($tr->type == 0)
                $tarif[$tr->id] = "Внутри города";
            else
                $tarif[$tr->id] = "За городом";
        }
        $orders_wait = Order::where('status', 0)->paginate(8);


        $orders = Order::where('status' != 0);

        if ($request->search != null || $request->search =="") {
            $orders = Order::where('status', '!=', 0)->where(function($query) use ($request){
                $query->orWhere('id', $request->search)
                ->with('automobile')->whereHas('automobile', function ($query) use ($request) {
                    $query->where('name', 'LIKE', "%$request->search%");
                })
                ->orWhere('name', 'LIKE', "%$request->search%")
                ->orWhere('sum', 'LIKE', "%$request->search%")
                ->orWhere('address_A', 'LIKE', "%$request->search%")
                ->orWhere('address_B', 'LIKE', "%$request->search%")
                ->orWhere('phone', 'LIKE', "%$request->search%");
        });

        }
        if ($request->filter == "name") {
            if (Session::get('sort')) {
                $orders = $orders
                    ->orderBy('name', 'desc');
                Session::put('sort', false);
            } else {
                $orders = $orders
                    ->orderBy('name', 'asc');
                Session::put('sort', true);
            }
        }
        if ($request->filter == "sum") {
            if (Session::get('sort')) {
                $orders = $orders
                    ->orderBy('sum', 'desc');
                Session::put('sort', false);
            } else {
                $orders = $orders
                    ->orderBy('sum', 'asc');
                Session::put('sort', true);
            }
        }
        if ($request->filter == "id") {

            if (Session::get('sort')) {
                $orders = $orders
                    ->orderBy('id', 'desc');
                Session::put('sort', false);
            } else {
                $orders = $orders
                    ->orderBy('id', 'asc');
                Session::put('sort', true);
            }
        }
        $orders = $orders->paginate(8);


        return view('operator')
            ->withCars($cars)->withTarifs($tarifs)->withCar($car)
            ->withTarif($tarif)->withOrders($orders)->withOrders_wait($orders_wait)->withSection(3);
    }

}
