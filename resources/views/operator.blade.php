@extends('layouts.app')
@section('head')
    <!--suppress ALL -->
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
    <style>
        label {
            margin-top: 6px;
        }

        .error {
            color: red;
        }

        @media screen and (max-width: 770px) {
            .navs {
                left: 10px;
            }
        }

        .section {
            display: none;
        }

        #navbar {
            /*display: none;*/
            margin: 0;
        }

        #loader {
            position: absolute;
            left: 50%;
            top: 50%;
            z-index: 1;
            width: 150px;
            height: 150px;
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
    <nav id="navigation" class="navbar navbar-default"
         style="/*display: none;*/ border-radius: 0; border-width: 0 0 thin 0;">
        <ul class="nav navbar-nav">
            <li data-toggle="tab" class="navs"><a onclick="switchSection('section1')"><i
                            class="fa fa-columns"></i>
                    Сделать заказ</a>
            </li>
            <li data-toggle="tab" class="navs"><a onclick="switchSection('section2')"><i
                            class="fa fa-list-alt"></i> Заказы</a></li>
            <li data-toggle="tab" class="navs"><a onclick="switchSection('section3')"><i
                            class="fa fa-handshake-o"></i> Поданные
                    заказы</a></li>
        </ul>
    </nav>
    <div id="container" class="container" style="/*display: none;*/ padding: 0 20px 20px 20px">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div id="section1" class="section">
                    <div class="page-header">
                        <h2>Сделать заказ</h2>
                    </div>
                    <div class="container-fluid">
                        <div class="row">
                            <h3>Грузоперевозки</h3>
                            <div class="col-md-12">
                                {{Form::open(['route' => ['operator.order.submit'], 'method' => 'post'])}}
                                <div class="panel panel-default">
                                    <div class="panel-heading">Заказ</div>
                                    <div class="panel-body">
                                        <div class="form-group col-md-12">
                                            <label class="col-md-3">Тариф</label>
                                            <div class="col-md-9">
                                                {{Form::select('tarif', $tarif, null, ['class'=>'form-control', 'onchange'=>'changeTarif()', 'id'=>'tarif_id'])}}
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label class="col-md-3">Тип автомобиля</label>
                                            <div class="col-md-9">
                                                {{Form::select('car', $car, null, ['class'=>'form-control', 'onchange' => 'changeCar()', 'id' => 'car_id'])}}
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label class="col-md-3">Количество грузчиков</label>
                                            <div class="col-md-9">
                                                {{Form::number('persons', 0, ['max' => 8, 'min'=>0, 'class'=>'form-control', 'id' =>'person_id', 'onchange' => 'personsChange()'])}}
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="date_id" class="col-md-3">Время подачи</label>
                                            <div class="col-md-6">
                                                <input type="date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                       name="date"
                                                       class="form-control"
                                                       id="date_id">
                                            </div>
                                            <div class="col-md-3">
                                                <input type="time"
                                                       value="{{ \Carbon\Carbon::now()->setTimezone('Asia/Tashkent')->format('H:i') }}"
                                                       name="time"
                                                       class="form-control" id="date_id">
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="unit_id" id="label_tarif" class="col-md-3">Срок аренды
                                                (час)</label>
                                            <div class="col-md-9">
                                                <input name="unit" type="number" step="0.01"
                                                       value="{{ $tarifs[0]->min_hour  }}" min="0.0"
                                                       class="form-control" required id="unit_id"
                                                       onchange="unitChange()">
                                            </div>
                                        </div>

                                        @if ($errors->has('point_A') || $errors->has('address_A'))
                                            <div class="col-md-4">
                                            <span class="help-block">
                                                <strong class="alert-danger">{{ $errors->first('point_A') }}</strong>
                                            </span>
                                            </div>
                                        @endif
                                        <div class="form-group col-md-12">
                                            <label class="col-md-3">Откуда</label>
                                            <div class="col-md-8">
                                                {{Form::text('address_A',null, ['class'=>'form-control', 'id'=>'address_a'])}}
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" class="btn btn-default" data-toggle="modal"
                                                        data-target="#myModal"
                                                        onclick="setStart()"><i class="fa fa-compass"></i></button>
                                            </div>
                                        </div>

                                        @if ($errors->has('point_B') || $errors->has('address_B'))
                                            <div class="col-md-4">
                                            <span class="help-block">
                                                <strong class="alert-danger">{{ $errors->first('point_B') }}</strong>
                                            </span>
                                            </div>
                                        @endif
                                        <div class="form-group col-md-12">
                                            <label class="col-md-3">Куда</label>
                                            <div class="col-md-8">
                                                {{Form::text('address_B',null, ['class'=>'form-control', 'id'=>'address_b'])}}
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" class="btn btn-default" data-toggle="modal"
                                                        data-target="#myModal"
                                                        onclick="setEnd()"><i class="fa fa-compass"></i></button>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            {{Form::hidden('point_A',null, ['id'=>'point_a', 'class'=>'form-control'])}}
                                        </div>
                                        <div class="col-md-4">
                                            {{Form::hidden('point_B',null,['id'=>'point_b', 'class'=>'form-control'])}}
                                        </div>

                                        @if ($errors->has('name'))
                                            <div class="col-md-4">
                                            <span class="help-block">
                                                <strong class="alert-danger">{{ $errors->first('name') }}</strong>
                                            </span>
                                            </div>
                                        @endif
                                        <div class="form-group col-md-12">
                                            <label class="col-md-3">Имя заказчика</label>
                                            <div class="col-md-9">
                                                {{Form::text('name',null,['class'=>'form-control'])}}
                                            </div>
                                        </div>
                                        @if ($errors->has('phone'))
                                            <div class="col-md-4">
                                            <span class="help-block">
                                                <strong class="alert-danger">{{ $errors->first('phone') }}</strong>
                                            </span>
                                            </div>
                                        @endif
                                        <div class="form-group col-md-12">
                                            <label class="col-md-3">Телефон</label>
                                            <div class="col-md-9">
                                                {{Form::text('phone','+998',['class'=>'form-control'])}}
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="discount_id" class="col-md-3">Скидка %</label>
                                            <div class="col-md-9">
                                                {{Form::number('discount', $tarifs[0]->discard, ['id' => 'discount_id', 'class' => 'form-control', 'readonly'])}}
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label class="col-md-3">Цена</label>
                                            <div class="col-md-9">
                                                {{Form::number('sum',null, ['class'=>'form-control', 'id'=>'sum_id'])}}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="panel-footer">
                                        <input type="submit" class="btn btn-success" value="Заказать">
                                    </div>

                                </div>
                                {{Form::close()}}
                            </div>
                        </div>

                        <div class="row">
                            <h3>Такси</h3>
                            <div class="col-md-12">
                                <form action="{{ route('operator.taxiorder.submit') }}" method="post">
                                    {{ csrf_field() }}
                                    <div class="panel panel-default">
                                        <div class="panel-heading">Заказ</div>
                                        <div class="panel-body">
                                            @if ($errors->has('taxi_point_A') || $errors->has('taxi_address_A'))
                                                <div class="col-md-12 error">
                                                    <label class="col-md-12">Пункт А не выбран</label>
                                                </div>
                                            @endif
                                            <div class="form-group col-md-12">
                                                <label class="col-md-3">Откуда:</label>
                                                <div class="col-md-8">
                                                    <input name="taxi_address_A" type="text" class="form-control">
                                                </div>
                                                <div class="col-md-1">
                                                    <button type="button" class="btn btn-default" data-toggle="modal"
                                                            data-target="#myModal"><i class="fa fa-compass"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            @if ($errors->has('taxi_point_B') || $errors->has('taxi_address_B'))
                                                <div class="col-md-12 error">
                                                    <label class="col-md-12">Пункт B не выбран</label>
                                                </div>
                                            @endif
                                            <div class="form-group col-md-12">
                                                <label class="col-md-3">Куда:</label>
                                                <div class="col-md-8">
                                                    <input name="taxi_address_B" type="text" class="form-control">
                                                </div>
                                                <div class="col-md-1">
                                                    <button type="button" class="btn btn-default" data-toggle="modal"
                                                            data-target="#myModal"><i class="fa fa-compass"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <input type="hidden" name="taxi_point_A">
                                            <input type="hidden" name="taxi_point_B">
                                            <div class="form-group col-md-12">
                                                <label class="col-md-3">Время подачи:</label>
                                                <div class="col-md-6">
                                                    <input type="date"
                                                           value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                           name="taxi_date" class="form-control">
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="taxi_time"
                                                           value="{{ \Carbon\Carbon::now()->setTimezone('Asia/Tashkent')->format('H:i') }}"
                                                           name="time" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label class="col-md-3">Время ожидания (мин):</label>
                                                <div class="col-md-3">
                                                    <input type="number" class="form-control" name="taxi_minute"
                                                           min="{{ $taxitarif->min_minute }}"
                                                           value="{{ $taxitarif->min_minute }}">
                                                </div>
                                                <label class="col-md-3">Дистанция (км):</label>
                                                <div class="col-md-3">
                                                    <input type="number" class="form-control" name="taxi_distance"
                                                           readonly>
                                                </div>
                                            </div>
                                            @if ($errors->has('taxi_name'))
                                                <div class="col-md-12 error">
                                                    <label class="col-md-12">Введите имя</label>
                                                </div>
                                            @endif
                                            <div class="form-group col-md-12">
                                                <label class="col-md-3">Имя заказчика:</label>
                                                <div class="col-md-9">
                                                    <input type="text" name="taxi_name" class="form-control">
                                                </div>
                                            </div>
                                            @if ($errors->has('taxi_phone'))
                                                <div class="col-md-12 error">
                                                    <label class="col-md-12">Введите телефон номер</label>
                                                </div>
                                            @endif
                                            <div class="form-group col-md-12">
                                                <label class="col-md-3">Телефон:</label>
                                                <div class="col-md-9">
                                                    <input type="text" name="taxi_phone" class="form-control"
                                                           value="+998">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label class="col-md-3">Скидка (%):</label>
                                                <div class="col-md-9">
                                                    <input type="number" name="taxi_discard" class="form-control"
                                                           readonly
                                                           value="{{ $taxitarif->discard }}">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label class="col-md-3">Цена (cyм):</label>
                                                <div class="col-md-9">
                                                    <input type="number" name="taxi_price" class="form-control"
                                                           value="{{ $taxitarif->price_minimum }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-footer">
                                            <input type="submit" class="btn btn-success" value="Заказать">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="modal fade" id="myModal" role="dialog">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">УКАЖИТЕ АДРЕС</h4>
                                    </div>
                                    <div class="modal-body" style="height: 500px; padding: 0;">
                                        <div id="map" class="col-md-12" style="height: 500px;"></div>
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
                        <h2>Заказы</h2>
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
                                                <strong>Дистанция:</strong>
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
                                    <table>
                                        <tbody>
                                        <tr>
                                            <td>
                                                <form method="post"
                                                      action="{{route('operator.order.accept',['order_id' => $order->id, 'operator_id' => Auth::guard('operator')->user()->id]
                                              )}}">
                                                    {{csrf_field()}}
                                                    <input type="submit" class="btn btn-success form-group"
                                                           value="Принять">
                                                </form>
                                            </td>
                                            <td>
                                                <form method="post"
                                                      action="{{route('operator.order.refuse',['order_id' => $order->id, 'operator_id' => Auth::guard('operator')->user()->id]
                                              )}}">
                                                    {{csrf_field()}}
                                                    <input type="submit" class="btn btn-warning form-group"
                                                           value="Отказать">
                                                </form>
                                            </td>
                                            <td>
                                                <form method="get"
                                                      action="{{route('operator.order.update',['id'=>$order->id])}}">
                                                    {{csrf_field()}}
                                                    <input type="submit" class="btn btn-primary form-group"
                                                           value="Изменить">
                                                </form>
                                            </td>
                                            <td>
                                                <form method="post" onsubmit="return confirm('Хотите удалить?');"
                                                      action="{{route('operator.order.delete', $order->id)}}">
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
                <div id="section3" class="section">
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
                        <div id="yourMap" class="col-md-12" style="height: 500px;"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыт</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--div id="loader"></div-->

    <script>
        var yourMap;
        var tarifs = {!! $tarifs !!};
        var cars = {!! $cars !!};
        var tarif_index = 0;
        var car_index = 0;
        var persons_price = 0;
        var unit = 0;
        var discount = 0;

        var myMap;
        var start = false;
        var end = false;
        var distance = 0;
        var path;

        function init() {
            yourMap = new ymaps.Map("yourMap", {
                center: [41.299496, 69.240073],
                zoom: 13,
                controls: []
            }, {searchControlProvider: 'yandex#search'});
            yourMap.controls.add('geolocationControl');
            yourMap.controls.add('searchControl');
            yourMap.controls.add('zoomControl');
            yourMap.controls.get('searchControl').options.set('size', 'large');

            myMap = new ymaps.Map("map", {
                center: [41.299496, 69.240073],
                zoom: 13,
                controls: []
            }, {searchControlProvider: 'yandex#search'});
            myMap.controls.add('geolocationControl');
            myMap.controls.add('searchControl');
            myMap.controls.add('zoomControl');
            myMap.controls.get('searchControl').options.set('size', 'large');

            myMap.events.add('click', function (event) {
                var coords = event.get('coords');
                if (start === false) {
                    start = new ymaps.Placemark(coords, {
                        balloonContent: 'Point A'
                    }, {
                        draggable: true,
                        preset: 'islands#icon',
                        iconColor: '#F44336'
                    });
                    myMap.geoObjects.add(start);
                    start.events.add('dragend', function (e) {
                        setCoordinates();
                    });
                }
                else {
                    if (end === false) {
                        end = new ymaps.Placemark(coords, {
                            balloonContent: 'Point B'
                        }, {
                            draggable: true,
                            preset: 'islands#icon',
                            iconColor: '#2196F3'
                        });
                        myMap.geoObjects.add(end);
                        end.events.add('dragend', function (e) {
                            setCoordinates();
                        });
                    }
                    else {
                        end.geometry.setCoordinates(coords);
                    }
                }
                setCoordinates();
            });
        }

        function setCoordinates() {
            if (start != false) {
                document.getElementById('point_a').value = start.geometry.getCoordinates();
                getAddress('address_a', start.geometry.getCoordinates());
            }

            if (end != false) {
                document.getElementById('point_b').value = end.geometry.getCoordinates();
                getAddress('address_b', end.geometry.getCoordinates());
            }

            if (start === false || end === false)
                return;

            if (path === null)
                return;

            myMap.geoObjects.remove(path);
            ymaps.route([start.geometry.getCoordinates(), end.geometry.getCoordinates()],
                    {
                        mapStateAutoApply: true,
                        multiRoute: false
                    }).then(function (route) {
                        path = route;
                        distance = route.getLength();
                        myMap.geoObjects.add(route);
                        if (tarif_index === 1) {
                            document.getElementById('unit_id').value = (distance / 1000).toFixed(2);
                            unitChange();
                        }
                    }, function (error) {
                        alert("Error occurred: " + error.message);
                    }
            );
        }

        function getAddress(id, coords) {
            ymaps.geocode(coords).then(function (res) {
                var firstGeoObject = res.geoObjects.get(0);
                document.getElementById(id).value = firstGeoObject.getAddressLine();
            });
        }

        ymaps.ready(init);

        function setStart() {
            myMap.geoObjects.remove(start);
            myMap.geoObjects.remove(path);
            start = false;
        }

        function changeTarif() {
            tarif_index = document.getElementById('tarif_id').selectedIndex;
            if (tarif_index === 0) {
                document.getElementById('label_tarif').innerHTML = "Срок аренды (час)";
                document.getElementById('unit_id').min = tarifs[tarif_index]['min_hour'];
                document.getElementById('unit_id').value = tarifs[tarif_index]['min_hour'];
                document.getElementById('unit_id').readOnly = false;
            }
            else {
                document.getElementById('label_tarif').innerHTML = "Дистанция";
                document.getElementById('unit_id').min = tarifs[tarif_index]['min_distance'];
                if (distance === 0)
                    document.getElementById('unit_id').value = tarifs[tarif_index]['min_distance'];
                else
                    document.getElementById('unit_id').value = (distance / 1000).toFixed(2);
                document.getElementById('unit_id').readOnly = true;
            }
            discount = document.getElementById('discount_id').value = tarifs[tarif_index]['discard'];
            calculatePrice();
        }

        function changeCar() {
            car_index = document.getElementById('car_id').selectedIndex;
            calculatePrice();
        }

        function personsChange() {
            persons_price = document.getElementById('person_id').value * tarifs[tarif_index]['price_per_person'];
            calculatePrice();
        }

        function unitChange() {
            if (document.getElementById('unit_id').value < 0)
                changeTarif();
            if (tarif_index === 0)
                unit = (document.getElementById('unit_id').value - tarifs[tarif_index]['min_hour']) * tarifs[tarif_index]['price_per_hour'];
            else
                unit = (document.getElementById('unit_id').value - tarifs[tarif_index]['min_distance']) * tarifs[tarif_index]['price_per_distance'];
            calculatePrice();
        }

        function calculatePrice() {
            var price = tarifs[tarif_index]['price_minimum'];
            price += cars[car_index]['price'];
            price += persons_price;
            price += unit;
            price -= price * discount / 100;
            document.getElementById('sum_id').value = price;
        }

        function switchSection(id) {
            document.cookie = "operatorPage=" + id + ";";
            var section = document.getElementsByClassName('section');
            for (var i = 0; i < section.length; i++)
                section[i].style.display = "none";
            document.getElementById(id).style.display = "block";
        }

        function getCookie(cname) {
            var name = cname + "=";
            var ca = document.cookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "section1";
        }

        function setPoints(point_a_1, point_a_2, point_b_1, point_b_2) {
            var point_a = point_a_1 + "," + point_a_2;
            var point_b = point_b_1 + "," + point_b_2;
            yourMap.geoObjects.removeAll();
            ymaps.route([point_a, point_b], {
                mapStateAutoApply: true,
                multiRoute: false
            }).then(function (route) {
                        yourMap.geoObjects.add(route);
                    }, function (error) {
                        alert("Error occurred: " + error.message);
                    }
            );
        }

        window.onload = function () {
            switchSection(getCookie("operatorPage"));
            var navs = document.getElementsByClassName("navs");
            navs[getCookie("operatorPage").replace("section", "") - 1].className = "navs active";
            document.getElementById("loader").style.display = "none";
            document.getElementById("navigation").style.display =
                    document.getElementById("container").style.display =
                            document.getElementById("navbar").style.display = "block";

            tarif_index = document.getElementById('tarif_id').selectedIndex = 0;
            car_index = document.getElementById('car_id').selectedIndex = 0;
            document.getElementById('person_id').value = 0;
            changeTarif();
            changeCar();
            personsChange();
            unitChange();
        };
    </script>
@endsection
