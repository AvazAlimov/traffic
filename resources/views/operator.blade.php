@extends('layouts.app')
@section('head')
    <link rel="stylesheet" href="{{ asset("css/bootstrap-datetimepicker.css") }}">
    <!--suppress CssUnusedSymbol -->
    <style xmlns:v-bind="http://www.w3.org/1999/xhtml">
        label {
            margin-top: 6px;
        }

        .icon {
            margin-right: 5px;
        }

        #container {
            display: none;
            padding: 0 0 20px 0;
        }

        #navigation {
            display: none;
            border-radius: 0;
            border-width: 0 0 thin 0;
        }

        @media screen and (max-width: 770px) {
            .navs {
                left: 10px;
            }

            .dropdown {
                left: 10px;
            }

            .page-header {
                text-align: center;
            }
        }

        .section {
            display: none;
        }

        #navbar {
            display: none;
            margin: 0;
        }

        #loader {
            position: absolute;
            left: 50%;
            top: 50%;
            z-index: 1;
            margin: -75px 0 0 -75px;
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #3498db;
            width: 120px;
            height: 120px;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
        }

        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
    </style>
@endsection
@section('content')
    <nav id="navigation" class="navbar navbar-default">
        <ul class="nav navbar-nav">
            <li data-toggle="tab" class="navs">
                <a onclick="switchSection('section1')">
                    <i class="fa fa-columns icon"></i>
                    Сделать заказ
                </a>
            </li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-list-alt icon"></i> Заказы <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li class="navs">
                        <a onclick="switchSection('section2')">
                            <i class="fa fa-truck icon"></i>
                            Грузоперевозка
                        </a>
                    </li>
                    <li class="navs">
                        <a onclick="switchSection('section3')">
                            <i class="fa fa-cab icon"></i>
                            Такси
                        </a>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-handshake-o icon"></i> Поданные заказы <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li class="navs">
                        <a onclick="switchSection('section4')">
                            <i class="fa fa-truck icon"></i>
                            Грузоперевозка
                        </a>
                    </li>
                    <li class="navs">
                        <a onclick="switchSection('section5')">
                            <i class="fa fa-cab icon"></i>
                            Такси
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>

    <div id="container" class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div id="section1" class="section">
                    <div class="has-success"
                         style="display: {{ Illuminate\Support\Facades\Session::has('message') ? 'block' : 'none' }};">
                        <h3>{{Illuminate\Support\Facades\Session::get('message')}}</h3>
                    </div>
                    <div class="page-header">
                        <h2>Сделать заказ</h2>
                    </div>
                    <div class="container-fluid">
                        <div class="row col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        Заказать
                                    </h3>
                                    <div class="btn-group btn-group-xs btn-toggle">
                                        <button class="btn active btn-default" data-toggle="tab"
                                                data-target="#trucking">
                                            Грузоперевозку
                                        </button>
                                        <button class="btn btn-default" data-toggle="tab"
                                                data-target="#taxi">
                                            Такси
                                        </button>
                                    </div>
                                </div>
                                <div class="panel-body tab-content">
                                    <div class="tab-pane active" id="trucking">
                                        <form action="{{ route('operator.order.submit') }}" method="post">
                                            {{csrf_field()}}
                                            <div class="form-group col-md-12">
                                                <label for="trucking_tariff_id" class="col-md-3">
                                                    Выберите тариф:
                                                </label>
                                                <div class="col-md-9">
                                                    <select name="tariff_id" id="trucking_tariff_id"
                                                            class="form-control" onchange="changeTariff()">
                                                        @foreach($tariff as $index=>$tarif)
                                                            <option value="{{$index}}">{{ $tarif}}</option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="trucking_automobile_id" class="col-md-3">
                                                    Выберите автомобиль:
                                                </label>
                                                <div class="col-md-9">
                                                    <select name="automobile_id" id="trucking_automobile_id"
                                                            class="form-control" onchange="changeAutomobile()">
                                                        @foreach($automobile as $index => $auto)
                                                            <option value="{{$index}}">{{ $auto }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="trucking_loaders" class="col-md-3">
                                                    Количество грузчиков:
                                                </label>
                                                <div class="col-md-2">
                                                    <input type="number" name="loaders" class="form-control"
                                                           id="trucking_loaders" min="0" max="8" value="0"
                                                           onchange="calculateTruckingPrice()">
                                                </div>
                                                <label class="col-md-1">человек</label>
                                            </div>
                                            <div class="form-group col-md-12" id="trucking_hour_wrapper">
                                                <label for="trucking_hour" class="col-md-3">
                                                    Срок аренды:
                                                </label>
                                                <div class="col-md-2">
                                                    <input type="number" name="hour" id="trucking_hour"
                                                           class="form-control" min="{{ $tariffs[0]->type == 0
                                                           ? $tariffs[0]->min_hour
                                                           : ($tariffs[1]->type == 0 ? $tariffs[1]->min_hour : 0) }}"
                                                           value="{{ $tariffs[0]->type == 0
                                                           ? $tariffs[0]->min_hour
                                                           : ($tariffs[1]->type == 0 ? $tariffs[1]->min_hour : 0) }}"
                                                           onchange="calculateTruckingPrice()">
                                                </div>
                                                <label class="col-md-1">час</label>
                                            </div>
                                            <div class="form-group col-md-12" id="trucking_distance_wrapper">
                                                <label for="trucking_distance" class="col-md-3">
                                                    Дистанция:
                                                </label>
                                                <div class="col-md-2">
                                                    <input type="number" name="distance" id="trucking_distance" step="2"
                                                           class="form-control" min="0" value="0" readonly>
                                                </div>
                                                <label class="col-md-1">километр</label>
                                            </div>
                                            <div class="col-md-12">
                                                <hr>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="trucking_start" class="col-md-3">
                                                    Время подачи:
                                                </label>
                                                <div class="col-md-3">
                                                    <input type="text" name="start"
                                                           value="{{ \Carbon\Carbon::now()
                                                           ->setTimezone('Asia/Tashkent')
                                                           ->format("Y-m-d H:i") }}"
                                                           class="form-control form_datetime"
                                                           id="trucking_start" readonly>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-12 {{ ($errors->has('address_a') || $errors->has('point_a')) ? ' has-error' : '' }}">
                                                <label for="trucking_address_a" class="col-md-3">
                                                    Откуда:
                                                </label>
                                                <div class="col-md-8">
                                                    <input type="text" name="address_a" class="form-control"
                                                           id="trucking_address_a">
                                                </div>
                                                <div class="col-md-1">
                                                    <button type="button" class="btn btn-default" data-toggle="modal"
                                                            data-target="#mainModal" onclick="setStartPoint()">
                                                        <i class="fa fa-map-marker"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-12 {{ ($errors->has('address_b') || $errors->has('point_b')) ? ' has-error' : '' }}">
                                                <label for="trucking_address_b" class="col-md-3">
                                                    Куда:
                                                </label>
                                                <div class="col-md-8">
                                                    <input type="text" name="address_b" class="form-control"
                                                           id="trucking_address_b">
                                                </div>
                                                <div class="col-md-1">
                                                    <button type="button" class="btn btn-default" data-toggle="modal"
                                                            data-target="#mainModal" onclick="setEndPoint()">
                                                        <i class="fa fa-map-marker"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <input type="hidden" name="point_a" id="trucking_point_a">
                                            <input type="hidden" name="point_b" id="trucking_point_b">

                                            <div class="form-group col-md-12 {{ $errors->has('name') ? ' has-error' : '' }}">
                                                <label for="trucking_name" class="col-md-3">
                                                    Имя заказчика:
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="text" name="name" id="trucking_name"
                                                           class="form-control">
                                                </div>
                                            </div>

                                            <div class="form-group col-md-12 {{ $errors->has('phone') ? ' has-error' : '' }}">
                                                <label for="trucking_phone" class="col-md-3">
                                                    Телефон заказчика:
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="text" name="phone" id="trucking_phone"
                                                           class="form-control" value="+998">
                                                </div>
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label for="trucking_discard" class="col-md-3">
                                                    Скидка:
                                                </label>
                                                <div class="col-md-2">
                                                    <input type="number" id="trucking_discard" class="form-control"
                                                           readonly>
                                                </div>
                                                <label class="col-md-1">%</label>
                                                <label for="trucking_discard_sum" class="col-md-2 text-right">
                                                    Цена скидки:
                                                </label>
                                                <div class="col-md-3">
                                                    <input type="number" id="trucking_discard_sum" class="form-control"
                                                           readonly>
                                                </div>
                                                <label class="col-md-1">сум</label>
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label for="trucking_price" class="col-md-3">
                                                    Итоговая цена:
                                                </label>
                                                <div class="col-md-3">
                                                    <input type="number" id="trucking_price" class="form-control"
                                                           name="price">
                                                </div>
                                                <label class="col-md-1">сум</label>
                                            </div>

                                            <div class="col-md-12">
                                                <hr>
                                            </div>

                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-success btn-block">
                                                    Заказать
                                                </button>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="tab-pane" id="taxi">
                                        <form action="{{ route('operator.taxiorder.submit') }}" method="post">
                                            {{csrf_field()}}
                                            <div class="form-group col-md-12">
                                                <label for="taxi_minute" class="col-md-3">
                                                    Время ожидание:
                                                </label>
                                                <div class="col-md-2">
                                                    <input type="number" name="minute" class="form-control"
                                                           id="taxi_minute" onchange="calculateTaxiPrice()"
                                                           min="{{ $taxi_tariff->min_minute }}"
                                                           value="{{ $taxi_tariff->min_minute }}">
                                                </div>
                                                <label class="col-md-1">
                                                    минут
                                                </label>
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label for="taxi_distance" class="col-md-3">
                                                    Дистанция:
                                                </label>
                                                <div class="col-md-2">
                                                    <input type="number" name="distance" class="form-control"
                                                           id="taxi_distance" min="0" step="2" value="0" readonly>
                                                </div>
                                                <label class="col-md-1">
                                                    км
                                                </label>
                                            </div>

                                            <div class="col-md-12">
                                                <hr>
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label for="taxi_start" class="col-md-3">
                                                    Время подачи:
                                                </label>
                                                <div class="col-md-3">
                                                    <input type="text" name="start"
                                                           value="{{ \Carbon\Carbon::now()
                                                           ->setTimezone('Asia/Tashkent')
                                                           ->format("Y-m-d H:i") }}"
                                                           class="form-control form_datetime"
                                                           id="taxi_start" readonly>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-12 {{ ($errors->has('address_a') || $errors->has('point_a')) ? ' has-error' : '' }}">
                                                <label for="taxi_address_a" class="col-md-3">
                                                    Откуда:
                                                </label>
                                                <div class="col-md-8">
                                                    <input type="text" name="address_a" class="form-control"
                                                           id="taxi_address_a">
                                                </div>
                                                <div class="col-md-1">
                                                    <button type="button" class="btn btn-default" data-toggle="modal"
                                                            data-target="#mainModal" onclick="setStartPoint()">
                                                        <i class="fa fa-map-marker"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-12 {{ ($errors->has('address_b') || $errors->has('point_b')) ? ' has-error' : '' }}">
                                                <label for="taxi_address_b" class="col-md-3">
                                                    Куда:
                                                </label>
                                                <div class="col-md-8">
                                                    <input type="text" name="address_b" class="form-control"
                                                           id="taxi_address_b">
                                                </div>
                                                <div class="col-md-1">
                                                    <button type="button" class="btn btn-default" data-toggle="modal"
                                                            data-target="#mainModal" onclick="setEndPoint()">
                                                        <i class="fa fa-map-marker"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <input type="hidden" name="point_a" id="taxi_point_a">
                                            <input type="hidden" name="point_b" id="taxi_point_b">

                                            <div class="form-group col-md-12 {{ $errors->has('name') ? ' has-error' : '' }}">
                                                <label for="taxi_name" class="col-md-3">
                                                    Имя заказчика:
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="text" name="name" id="taxi_name"
                                                           class="form-control">
                                                </div>
                                            </div>

                                            <div class="form-group col-md-12 {{ $errors->has('phone') ? ' has-error' : '' }}">
                                                <label for="taxi_phone" class="col-md-3">
                                                    Телефон заказчика:
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="text" name="phone" id="taxi_phone"
                                                           class="form-control" value="+998">
                                                </div>
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label for="taxi_discard" class="col-md-3">
                                                    Скидка:
                                                </label>
                                                <div class="col-md-2">
                                                    <input type="number" id="taxi_discard" class="form-control"
                                                           readonly value="{{ $taxi_tariff->discard }}">
                                                </div>
                                                <label class="col-md-1">%</label>
                                                <label for="taxi_discard_sum" class="col-md-2 text-right">
                                                    Цена скидки:
                                                </label>
                                                <div class="col-md-3">
                                                    <input type="number" id="taxi_discard_sum" class="form-control"
                                                           readonly>
                                                </div>
                                                <label class="col-md-1">сум</label>
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label for="taxi_price" class="col-md-3">
                                                    Итоговая цена:
                                                </label>
                                                <div class="col-md-3">
                                                    <input type="number" id="taxi_price" class="form-control"
                                                           name="price">
                                                </div>
                                                <label class="col-md-1">сум</label>
                                            </div>

                                            <div class="col-md-12">
                                                <hr>
                                            </div>

                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-success btn-block">
                                                    Заказать
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="mainModal" role="dialog">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">УКАЖИТЕ АДРЕС</h4>
                                    </div>
                                    <div class="modal-body" style="height: 500px; padding: 0;">
                                        <div id="navigationMap" class="col-md-12" style="height: 500px;"></div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Сохранить
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="section2" class="section">
                    <div class="page-header">
                        <h2>Заказы на грузоперевозки</h2>
                    </div>
                    @foreach($orders_wait as $order)
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Идентификационный номер
                                    заказа: {{ $order->id }}
                                </div>
                                <div class="panel-body">
                                    <div class="form-group col-md-12">
                                        <div class="col-md-4"><strong>Тариф:</strong></div>
                                        <div class="col-md-8">
                                            @if($order->tarif->type == 0)
                                                Внутри города
                                            @else
                                                За городом
                                            @endif</div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="col-md-4"><strong>Тип автомобиля:</strong></div>
                                        <div class="col-md-8">{{ $order->automobile->name }}</div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="col-md-4"><strong>Количество грузчиков:</strong></div>
                                        <div class="col-md-8">{{ $order->persons }}</div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="col-md-4"><strong>Время подачи:</strong></div>
                                        <div class="col-md-8">{{ $order->start_time }}</div>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <div class="col-md-4">
                                            @if($order->tarif->type == 0)
                                                <strong>Срок аренды (час):</strong>
                                            @else
                                                <strong>Дистанция (км):</strong>
                                            @endif
                                        </div>
                                        <div class="col-md-8">
                                            {{ $order->unit }}
                                        </div>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <div class="col-md-4"><strong>Откуда:</strong></div>
                                        <div class="col-md-8">{{ $order->address_A }}</div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="col-md-4"><strong>Куда:</strong></div>
                                        <div class="col-md-8">{{ $order->address_B }}</div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="col-md-4"><strong>Имя заказчика:</strong></div>
                                        <div class="col-md-8">{{ $order->name  }}</div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="col-md-4"><strong>Телефон:</strong></div>
                                        <div class="col-md-8">{{ $order->phone }}</div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="col-md-4"><strong>Цена:</strong></div>
                                        <div class="col-md-8">{{ $order->sum }} сум</div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="col-md-4"><strong>Показать на карте:</strong></div>
                                        <div class="col-md-8">
                                            <button type="button" class="btn btn-default" data-toggle="modal"
                                                    data-target="#yourModal"
                                                    onclick="setPoints({{$order->point_A}} + '',{{$order->point_B}} + '')">
                                                <i class="fa fa-compass"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <form method="post"
                                                  action="{{route('operator.order.accept',['order_id' => $order->id, 'operator_id' => Illuminate\Support\Facades\Auth::guard('operator')->user()->id]
                                              )}}">
                                                {{csrf_field()}}
                                                <input type="submit" class="btn btn-block btn-success form-group"
                                                       value="Принять">
                                            </form>
                                        </div>
                                        <div class="col-md-2">
                                            <form method="post"
                                                  action="{{route('operator.order.refuse',['order_id' => $order->id, 'operator_id' => Illuminate\Support\Facades\Auth::guard('operator')->user()->id]
                                              )}}">
                                                {{csrf_field()}}
                                                <input type="submit" class="btn btn-block btn-warning form-group"
                                                       value="Отказать">
                                            </form>
                                        </div>
                                        <div class="col-md-2">
                                            <form method="get"
                                                  action="{{route('operator.order.update',['id'=>$order->id])}}">
                                                {{csrf_field()}}
                                                <input type="submit" class="btn btn-block btn-primary form-group"
                                                       value="Изменить">
                                            </form>
                                        </div>
                                        <div class="col-md-2">
                                            <form method="post" onsubmit="return confirm('Хотите удалить?');"
                                                  action="{{route('operator.order.delete', $order->id)}}">
                                                {{csrf_field()}}
                                                <input type="submit" class="btn btn-block btn-danger" value="Удалить">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div id="section3" class="section">
                    <div class="page-header">
                        <h2>Заказы Такси</h2>
                    </div>
                    @foreach($taxi_orders_wait as $order)
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Идентификационный номер
                                    заказа: {{ $order->id }}
                                </div>
                                <div class="panel-body">
                                    <div class="form-group col-md-12">
                                        <div class="col-md-4"><strong>Время подачи:</strong></div>
                                        <div class="col-md-8">{{ $order->start_time }}</div>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <div class="col-md-4">
                                            <strong>Время ожидания (мин):</strong>
                                        </div>
                                        <div class="col-md-8">
                                            {{ $order->minute }}
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="col-md-4">
                                            <strong>Дистанция (км):</strong>
                                        </div>
                                        <div class="col-md-8">
                                            {{ $order->distance }}
                                        </div>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <div class="col-md-4"><strong>Откуда:</strong></div>
                                        <div class="col-md-8">{{ $order->address_A }}</div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="col-md-4"><strong>Куда:</strong></div>
                                        <div class="col-md-8">{{ $order->address_B }}</div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="col-md-4"><strong>Имя заказчика:</strong></div>
                                        <div class="col-md-8">{{ $order->name  }}</div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="col-md-4"><strong>Телефон:</strong></div>
                                        <div class="col-md-8">{{ $order->phone }}</div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="col-md-4"><strong>Цена:</strong></div>
                                        <div class="col-md-8">{{ $order->price }} сум</div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="col-md-4"><strong>Показать на карте:</strong></div>
                                        <div class="col-md-8">
                                            <button type="button" class="btn btn-default" data-toggle="modal"
                                                    data-target="#yourModal"
                                                    onclick="setPoints({{$order->point_A}} + '',{{$order->point_B}} + '')">
                                                <i class="fa fa-compass"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <table>
                                        <tbody>
                                        <tr>
                                            <td>
                                                <form method="post"
                                                      action="{{route('operator.taxiorder.accept',['order_id' => $order->id, 'operator_id' => Illuminate\Support\Facades\Auth::guard('operator')->user()->id]
                                              )}}">
                                                    {{csrf_field()}}
                                                    <input type="submit" class="btn btn-success form-group"
                                                           value="Принять">
                                                </form>
                                            </td>
                                            <td>
                                                <form method="post"
                                                      action="{{route('operator.taxiorder.refuse',['order_id' => $order->id, 'operator_id' => Illuminate\Support\Facades\Auth::guard('operator')->user()->id]
                                              )}}">
                                                    {{csrf_field()}}
                                                    <input type="submit" class="btn btn-warning form-group"
                                                           value="Отказать">
                                                </form>
                                            </td>
                                            <td>
                                                <form method="get"
                                                      action="{{route('operator.taxiorder.update',['id'=>$order->id])}}">
                                                    {{csrf_field()}}
                                                    <input type="submit" class="btn btn-primary form-group"
                                                           value="Изменить">
                                                </form>
                                            </td>
                                            <td>
                                                <form method="post" onsubmit="return confirm('Хотите удалить?');"
                                                      action="{{route('operator.taxiorder.delete', $order->id)}}">
                                                    {{csrf_field()}}
                                                    <input type="submit" class="btn btn-danger" value="Удалить">
                                                </form>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div id="section4" class="section">
                    <div class="page-header">
                        <h2>Поданные заказы</h2>
                    </div>
                    <form action="{{route('operator.search')}}" method="post">
                        {{csrf_field()}}
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Найти"/>
                            <span class="input-group-btn">
                              <button type="submit" class="btn btn-default">
                                <i class="fa fa-search" aria-hidden="true"></i>
                              </button>
                             </span>
                        </div>
                    </form>
                    <h3>Сортировать по:</h3>
                    <div class="col-md-12" style="margin-bottom: 24px;">
                        <form class="col-md-3" action="{{route('operator.search')}}" method="post">
                            {{csrf_field()}}

                            <button type="submit" name="filter" value="id" class="btn btn-default"
                                    style="display: block; width: 100%;">
                                Ид номеру
                            </button>
                        </form>
                        <form class="col-md-3" action="{{route('operator.search')}}" method="post">
                            {{csrf_field()}}
                            <button type="submit" name="filter" value="name" class="btn btn-default"
                                    style="display: block; width: 100%;">
                                Именам
                            </button>
                        </form>
                        <form class="col-md-3" action="{{route('operator.search')}}" method="post">
                            {{csrf_field()}}
                            <button type="submit" name="filter" value="sum" class="btn btn-default"
                                    style="display: block; width: 100%;">
                                Ценам
                            </button>
                        </form>
                        <form class="col-md-3" action="{{route('operator.search')}}" method="post">
                            {{csrf_field()}}
                            <button type="submit" name="filter" value="date" class="btn btn-default"
                                    style="display: block; width: 100%;">
                                Время подачи
                            </button>
                        </form>
                    </div>
                    @foreach($orders as $served_order)
                        <div class="col-md-12">
                            <div class="panel panel-{{ $served_order->status == -1 ? "danger" : "success" }}">
                                <div class="panel-heading">
                                    Идентификационный номер
                                    заказа: {{ $served_order->id }}
                                </div>
                                <div class="panel-body">
                                    <div class="form-group col-md-12">
                                        <div class="col-md-4"><strong>Тариф:</strong></div>
                                        <div class="col-md-8">
                                            @if($served_order->tarif->type == 0)
                                                Внутри города
                                            @else
                                                За городом
                                            @endif</div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="col-md-4"><strong>Тип автомобиля:</strong></div>
                                        <div class="col-md-8">{{ $served_order->automobile->name }}</div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="col-md-4"><strong>Количество грузчиков:</strong></div>
                                        <div class="col-md-8">{{ $served_order->persons }}</div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="col-md-4"><strong>Время подачи:</strong></div>
                                        <div class="col-md-8">{{ $served_order->start_time }}</div>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <div class="col-md-4">
                                            @if($served_order->tarif->type == 0)
                                                <strong>Срок аренды (час):</strong>
                                            @else
                                                <strong>Дистанция:</strong>
                                            @endif
                                        </div>
                                        <div class="col-md-8">
                                            {{ $served_order->unit }}
                                        </div>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <div class="col-md-4"><strong>Откуда:</strong></div>
                                        <div class="col-md-8">{{ $served_order->address_A }}</div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="col-md-4"><strong>Куда:</strong></div>
                                        <div class="col-md-8">{{ $served_order->address_B }}</div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="col-md-4"><strong>Имя заказчика:</strong></div>
                                        <div class="col-md-8">{{ $served_order->name  }}</div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="col-md-4"><strong>Телефон:</strong></div>
                                        <div class="col-md-8">{{ $served_order->phone }}</div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="col-md-4"><strong>Цена:</strong></div>
                                        <div class="col-md-8">{{ $served_order->sum }} сум</div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="col-md-4"><strong>Показать на карте:</strong></div>
                                        <div class="col-md-8">
                                            <button type="button" class="btn btn-default" data-toggle="modal"
                                                    data-target="#yourModal"
                                                    onclick="setPoints({{$served_order->point_A}} + '',{{$served_order->point_B}} + '')">
                                                <i class="fa fa-compass"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <table>
                                        <tbody>
                                        <tr>
                                            <td>
                                                <form method="post" onsubmit="return confirm('Восстановить?');"
                                                      action="{{route('operator.order.restore', $served_order->id)}}">
                                                    {{csrf_field()}}
                                                    <input type="submit" class="btn btn-primary"
                                                           value="Восстановить">
                                                </form>
                                            </td>
                                            <td>
                                                <form method="post" onsubmit="return confirm('Хотите удалить?');"
                                                      action="{{route('operator.order.delete', $served_order->id)}}">
                                                    {{csrf_field()}}
                                                    <input type="submit" class="btn btn-danger" value="Удалить">
                                                </form>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="col-md-12">
                        {{ $orders->links() }}
                    </div>
                </div>
                <div id="section5" class="section">
                    <div class="page-header">
                        <h2>Поданные заказы</h2>
                    </div>
                    <form action="{{route('operator.taxi.search')}}" method="post">
                        {{csrf_field()}}
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Найти"/>
                            <span class="input-group-btn">
                              <button type="submit" class="btn btn-default">
                                <i class="fa fa-search" aria-hidden="true"></i>
                              </button>
                             </span>
                        </div>
                    </form>
                    <h3>Сортировать по:</h3>
                    <div class="col-md-12" style="margin-bottom: 24px;">
                        <form class="col-md-3" action="{{route('operator.taxi.search')}}" method="post">
                            {{csrf_field()}}

                            <button type="submit" name="filter" value="id" class="btn btn-default"
                                    style="display: block; width: 100%;">
                                Ид номеру
                            </button>
                        </form>
                        <form class="col-md-3" action="{{route('operator.taxi.search')}}" method="post">
                            {{csrf_field()}}
                            <button type="submit" name="filter" value="name" class="btn btn-default"
                                    style="display: block; width: 100%;">
                                Именам
                            </button>
                        </form>
                        <form class="col-md-3" action="{{route('operator.taxi.search')}}" method="post">
                            {{csrf_field()}}
                            <button type="submit" name="filter" value="sum" class="btn btn-default"
                                    style="display: block; width: 100%;">
                                Ценам
                            </button>
                        </form>
                        <form class="col-md-3" action="{{route('operator.taxi.search')}}" method="post">
                            {{csrf_field()}}
                            <button type="submit" name="filter" value="date" class="btn btn-default"
                                    style="display: block; width: 100%;">
                                Время подачи
                            </button>
                        </form>
                    </div>
                    @foreach($taxi_orders as $served_order)
                        <div class="col-md-12">
                            <div class="panel panel-{{ $served_order->status == -1 ? "danger" : "success" }}">
                                <div class="panel-heading">
                                    Идентификационный номер
                                    заказа: {{ $served_order->id }}
                                </div>
                                <div class="panel-body">
                                    <div class="form-group col-md-12">
                                        <div class="col-md-4"><strong>Время подачи:</strong></div>
                                        <div class="col-md-8">{{ $served_order->start_time }}</div>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <div class="col-md-4">
                                            <strong>Время ожидания (мин):</strong>
                                        </div>
                                        <div class="col-md-8">
                                            {{ $served_order->minute }}
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="col-md-4">
                                            <strong>Дистанчия (км)</strong>
                                        </div>
                                        <div class="col-md-8">
                                            {{ $served_order->distance }}
                                        </div>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <div class="col-md-4"><strong>Откуда:</strong></div>
                                        <div class="col-md-8">{{ $served_order->address_A }}</div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="col-md-4"><strong>Куда:</strong></div>
                                        <div class="col-md-8">{{ $served_order->address_B }}</div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="col-md-4"><strong>Имя заказчика:</strong></div>
                                        <div class="col-md-8">{{ $served_order->name  }}</div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="col-md-4"><strong>Телефон:</strong></div>
                                        <div class="col-md-8">{{ $served_order->phone }}</div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="col-md-4"><strong>Цена:</strong></div>
                                        <div class="col-md-8">{{ $served_order->price }} сум</div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="col-md-4"><strong>Показать на карте:</strong></div>
                                        <div class="col-md-8">
                                            <button type="button" class="btn btn-default" data-toggle="modal"
                                                    data-target="#yourModal"
                                                    onclick="setPoints({{$served_order->point_A}} + ''
                                                            ,{{$served_order->point_B}} + '')">
                                                <i class="fa fa-compass"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <table>
                                        <tbody>
                                        <tr>
                                            <td>
                                                <form method="post" onsubmit="return confirm('Восстановить?');"
                                                      action="{{route('operator.order.restore', $served_order->id)}}">
                                                    {{csrf_field()}}
                                                    <input type="submit" class="btn btn-primary"
                                                           value="Восстановить">
                                                </form>
                                            </td>
                                            <td>
                                                <form method="post" onsubmit="return confirm('Хотите удалить?');"
                                                      action="{{route('operator.order.delete', $served_order->id)}}">
                                                    {{csrf_field()}}
                                                    <input type="submit" class="btn btn-danger" value="Удалить">
                                                </form>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="col-md-12">
                        {{ $taxi_orders->links() }}
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="yourModal" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Карта</h4>
                    </div>
                    <div class="modal-body" style="height: 500px; padding: 0;">
                        <div id="showMap" class="col-md-12" style="height: 500px;"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыт</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="loader"></div>
@endsection
@section('scripts')
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
    <script src="{{ asset("js/bootstrap-datetimepicker.js") }}"></script>
    <!--suppress JSUnresolvedVariable, JSUnresolvedFunction -->
    <script>
        //----- Page Scripts Start -----//
        $(".btn-group > .btn").click(function () {
            $(this).addClass("active").siblings().removeClass("active");
        });

        $(".form_datetime").datetimepicker({format: 'yyyy-mm-dd hh:ii'});

        function switchSection(id) {
            document.cookie = "operatorPage=" + id + ";";
            var navs = document.getElementsByClassName("navs");
            for (var nav = 0; nav < navs.length; nav++)
                navs[nav].className = "navs";
            navs[id.replace("section", "") - 1].className = "navs active";
            var section = document.getElementsByClassName('section');
            for (var i = 0; i < section.length; i++)
                section[i].style.display = "none";
            document.getElementById(id).style.display = "block";
        }

        function getCookie(key) {
            var name = key + "=";
            var values = document.cookie.split(';');
            for (var i = 0; i < values.length; i++) {
                var c = values[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "section1";
        }
        //----- Page Scripts End -----//


        //----- Maps Scripts Start -----//
        var navigationMap;
        var showMap;
        var startPoint = false;
        var endPoint = false;
        var distance = 0;
        var path;

        function initMaps() {
            showMap = new ymaps.Map("showMap", {
                center: [41.299496, 69.240073],
                zoom: 13,
                controls: []
            }, {searchControlProvider: 'yandex#search'});

            navigationMap = new ymaps.Map("navigationMap", {
                center: [41.299496, 69.240073],
                zoom: 13,
                controls: []
            }, {searchControlProvider: 'yandex#search'});

            navigationMap.controls.add('geolocationControl');
            navigationMap.controls.add('searchControl');
            navigationMap.controls.add('zoomControl');
            navigationMap.controls.get('searchControl').options.set('size', 'large');

            navigationMap.events.add('click', function (event) {
                var coords = event.get('coords');
                if (startPoint === false) {
                    startPoint = new ymaps.Placemark(coords, {balloonContent: 'Пункт А'}, {
                        draggable: true,
                        preset: 'islands#redHomeIcon',
                        iconColor: '#F44336'
                    });
                    navigationMap.geoObjects.add(startPoint);

                    startPoint.events.add('dragend', function () {
                        setPoint(startPoint);
                    });

                    setPoint(startPoint);
                    return;
                }
                if (endPoint === false) {
                    endPoint = new ymaps.Placemark(coords, {balloonContent: 'Пункт А'}, {
                        draggable: true,
                        preset: 'islands#redGovernmentIcon',
                        iconColor: '#F44336'
                    });
                    navigationMap.geoObjects.add(endPoint);

                    endPoint.events.add('dragend', function () {
                        setPoint(endPoint);
                    });

                    setPoint(endPoint);
                }
            })
        }

        function setPoint(placemark) {
            var coords = placemark.geometry.getCoordinates();
            ymaps.geocode(coords).then(function (res) {
                var firstGeoObject = res.geoObjects.get(0);
                if (placemark === startPoint) {
                    document.getElementById("trucking_address_a").value = firstGeoObject.getAddressLine();
                    document.getElementById("taxi_address_a").value = firstGeoObject.getAddressLine();
                    document.getElementById("trucking_point_a").value = coords;
                    document.getElementById("taxi_point_a").value = coords;
                }
                if (placemark === endPoint) {
                    document.getElementById("trucking_address_b").value = firstGeoObject.getAddressLine();
                    document.getElementById("taxi_address_b").value = firstGeoObject.getAddressLine();
                    document.getElementById("trucking_point_b").value = coords;
                    document.getElementById("taxi_point_b").value = coords;
                }
            });
            drawPath();
        }

        function drawPath() {
            if (startPoint === false || endPoint === false)
                return;

            navigationMap.geoObjects.remove(path);

            ymaps.route([startPoint.geometry.getCoordinates(), endPoint.geometry.getCoordinates()], {
                mapStateAutoApply: true,
                multiRoute: false
            }).then(function (route) {
                        path = route;
                        distance = (route.getLength() / 1000).toFixed(2);
                        navigationMap.geoObjects.add(route);
                        path.getWayPoints().removeAll();
                        document.getElementById("trucking_distance").value = distance;
                        document.getElementById("taxi_distance").value = distance;
                        calculateTruckingPrice();
                        calculateTaxiPrice();
                    }, function (error) {
                        alert("Возникла ошибка: " + error.message);
                    }
            );
        }

        function setStartPoint() {
            if (startPoint !== false) {
                navigationMap.geoObjects.remove(startPoint);
                navigationMap.geoObjects.remove(path);
                startPoint = false;
                path = null;
                document.getElementById("trucking_address_a").value =
                        document.getElementById("taxi_address_a").value =
                                document.getElementById("trucking_point_a").value =
                                        document.getElementById("taxi_point_a").value = "";
            }
        }

        function setEndPoint() {
            if (endPoint !== false) {
                navigationMap.geoObjects.remove(endPoint);
                navigationMap.geoObjects.remove(path);
                endPoint = false;
                path = null;
                document.getElementById("trucking_address_b").value =
                        document.getElementById("taxi_address_b").value =
                                document.getElementById("trucking_point_b").value =
                                        document.getElementById("taxi_point_b").value = "";
            }
        }

        function setPoints(point_a_1, point_a_2, point_b_1, point_b_2) {
            var point_a = point_a_1 + "," + point_a_2;
            var point_b = point_b_1 + "," + point_b_2;
            showMap.geoObjects.removeAll();
            ymaps.route([point_a, point_b], {
                mapStateAutoApply: true,
                multiRoute: false
            }).then(function (route) {
                        showMap.geoObjects.add(route);
                    }, function (error) {
                        alert("Error occurred: " + error.message);
                    }
            );
        }

        ymaps.ready(initMaps);
        //----- Maps Scripts End -----//

        //----- Trucking Calculation Scripts Start -----//
        var arrays = [{!! $tariffs !!}];
        arrays.push({!! $automobiles !!});
        var tariff_index = document.getElementById("trucking_tariff_id").selectedIndex = 0;
        var car_index = document.getElementById("trucking_automobile_id").selectedIndex = 0;

        function changeTariff() {
            tariff_index = document.getElementById("trucking_tariff_id").selectedIndex;
            if (tariff_index === 0) {
                document.getElementById("trucking_hour_wrapper").style.display = "block";
                document.getElementById("trucking_distance_wrapper").style.display = "none";
            } else {
                document.getElementById("trucking_hour_wrapper").style.display = "none";
                document.getElementById("trucking_distance_wrapper").style.display = "block";
            }
            document.getElementById("trucking_discard").value = arrays[0][tariff_index]['discard'];
            calculateTruckingPrice();
        }

        function changeAutomobile() {
            car_index = document.getElementById("trucking_automobile_id").selectedIndex;
            calculateTruckingPrice();
        }

        function calculateTruckingPrice() {
            var price = arrays[0][tariff_index]['price_minimum'];
            price += arrays[1][car_index]['price'];
            price += arrays[0][tariff_index]['price_per_person'] * document.getElementById("trucking_loaders").value;
            if (arrays[0][tariff_index]['type'] === 0 &&
                    (document.getElementById("trucking_hour").value > arrays[0][tariff_index]['min_hour']))
                price += arrays[0][tariff_index]['price_per_hour'] * (document.getElementById("trucking_hour").value -
                        arrays[0][tariff_index]['min_hour']);
            else if (document.getElementById("trucking_distance").value > arrays[0][tariff_index]['min_distance'])
                price += arrays[0][tariff_index]['price_per_distance'] *
                        (document.getElementById("trucking_distance").value - arrays[0][tariff_index]['min_distance']);
            document.getElementById("trucking_discard_sum").value = price * arrays[0][tariff_index]['discard'] / 100;
            document.getElementById("trucking_price").value = price - (price * arrays[0][tariff_index]['discard'] / 100);
        }
        //----- Trucking Calculation Scripts End -----//

        //----- Taxi Calculation Scripts Start -----//
        var taxiTariff = [{!! $taxi_tariff !!}];

        function calculateTaxiPrice() {
            var price = taxiTariff[0]['price_minimum'];
            if (document.getElementById("taxi_minute").value > taxiTariff[0]['min_minute'])
                price += taxiTariff[0]['price_per_minute'] *
                        (document.getElementById("taxi_minute").value - taxiTariff[0]['min_minute']);
            if (document.getElementById("taxi_distance").value > taxiTariff[0]['min_distance'])
                price += taxiTariff[0]['price_per_distance'] *
                        (document.getElementById("taxi_distance").value - taxiTariff[0]['min_distance']);
            document.getElementById("taxi_discard_sum").value = price * taxiTariff[0]['discard'] / 100;
            document.getElementById("taxi_price").value = price - (price * taxiTariff[0]['discard'] / 100);
        }
        //----- Taxi Calculation Scripts End -----//

        window.onload = function () {
            switchSection(getCookie("operatorPage"));
            var navs = document.getElementsByClassName("navs");
            navs[getCookie("operatorPage").replace("section", "") - 1].className = "navs active";
            document.getElementById("loader").style.display = "none";
            document.getElementById("navigation").style.display =
                    document.getElementById("container").style.display =
                            document.getElementById("navbar").style.display = "block";
            changeTariff();
            changeAutomobile();
            calculateTaxiPrice();
        };
    </script>
@endsection
