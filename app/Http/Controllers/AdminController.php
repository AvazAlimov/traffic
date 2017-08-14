<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Tarif;
use App\Order;
use App\TaxiTarif;

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
        $orders = Order::where('status', '>', 0)->get();
        $taxi_tarif = TaxiTarif::first();

        return view('admin')
            ->with('automobiles', $automobiles)
            ->with('operators', $operators)
            ->with('tarifs', $tariffs)
            ->with('orders', $orders)
            ->with('taxiTarif', $taxi_tarif);
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

    public function updateTaxiTarif(Request $request, $id)
    {
        $taxitarif = TaxiTarif::find($id);
        $taxitarif->price_per_minute = $request->price_per_minute;
        $taxitarif->min_minute = $request->min_minute;
        $taxitarif->price_per_distance = $request->price_per_distance;
        $taxitarif->min_distance = $request->min_distance;
        $taxitarif->price_minimum = $request->price_minimum;
        $taxitarif->discard = $request->discard;
        $taxitarif->save();
        return redirect()->back();
    }

    public function orderToExcel()
    {
        $orders = Order::select('id', 'car_id', 'tarif_id', 'point_A', 'point_B', 'address_A', 'address_B', 'unit', 'persons', 'start_time', 'phone', 'name', 'sum', 'created_at', 'updated_at')->where('status', '>', 0)->get();
        $temp = array();
        foreach ($orders as $order) {
            $item = array();
            array_push($item, $order->id);
            array_push($item, $order->automobile->name);
            array_push($item, $order->tarif->type == 0 ? "Внутри города" : "За городом");
            array_push($item, $order->point_A);
            array_push($item, $order->point_B);
            array_push($item, $order->address_A);
            array_push($item, $order->address_B);
            array_push($item, $order->unit);
            array_push($item, $order->persons);
            array_push($item, $order->start_time);
            array_push($item, $order->phone);
            array_push($item, $order->name);
            array_push($item, $order->sum);
            array_push($item, $order->created_at);
            array_push($item, $order->updated_at);

            array_push($temp, $item);
        }
        $orders = $temp;
        Excel::create('Заказы', function ($excel) use ($orders) {
            $excel->sheet('Лист 1', function ($sheet) use ($orders) {
                $sheet->fromArray($orders);
                $sheet->row(1, array('идентификационный номер', 'автомобиль', 'тариф', 'пункт а', 'пункт б', 'адрес а', 'адрес б', 'Срок(час)/дистанция(км)', 'количество грузчиков', 'время подачи', 'телефон номер', 'имя заказчика', 'цена', 'создан', 'обновлен'));
            });
        })->export('xls');
    }
}
