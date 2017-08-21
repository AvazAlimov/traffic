<?php

namespace App\Http\Controllers;

use App\Automobile;
use App\Notifications\OrderNotification;
use App\Notifications\TaxiOrderNotification;
use App\Tarif;
use App\TaxiOrder;
use App\TaxiTarif;
use Illuminate\Http\Request;
use App\Order;
use Illuminate\Support\Facades\Validator;


class WebController extends Controller
{
    public function index()
    {
        $tariffs = Tarif::all();
        $tariff = array();
        $taxi_tariff = TaxiTarif::first();
        foreach ($tariffs as $tr) {
            if ($tr->type == 0)
                $tariff[$tr->id] = "Внутри города";
            else
                $tariff[$tr->id] = "За городом";
        }
        $automobiles = Automobile::all();
        $automobile = array();
        foreach ($automobiles as $key) {
            $automobile[$key->id] = $key->name;
        }
        return view('welcome')
            ->withTariff($tariff)
            ->withTariffs($tariffs)
            ->withTaxi_tariff($taxi_tariff)
            ->withAutomobile($automobile)
            ->withAutomobiles($automobiles);
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

        Validator::make($request->all(), $rules, $messages)->validate();

        $order = new Order;
        $order->user_type = 0;

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
        $order->operator_id = null;
        $order->save();
        $order->notify(new OrderNotification());
        return redirect()->back();
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
        $order->user_type = 0;
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
        $order->status = 0;

        $order->save();
        $order->notify(new TaxiOrderNotification());
        return redirect()->back();
    }
}
