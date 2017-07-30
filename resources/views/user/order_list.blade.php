@extends('layouts.main')

@section('content')

    <div class="container" style="margin-top: 20px;">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div id="section2" class="section">
                    <div class="page-header">
                        <h2>Заказы (статус != 0)</h2>
                    </div>

                    @foreach($orders as $served_order)
                        @if($served_order->status != 0)
                            <div class="col-md-6">
                                <div class="panel panel-{{ $served_order->status == -1 ? "danger" : "success" }}">
                                    <div class="panel-heading">
                                        Имя заказчика : {{ $served_order->name  }}
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
                                                        onclick="setPoints({{$served_order->point_A}},{{$served_order->point_B}})">
                                                    <i class="fa fa-compass"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div id="section3" class="section">
                    <div class="page-header">
                        <h2>Заказы (статус 0)</h2>
                    </div>
                    @foreach($orders as $order)
                        @if($order->status == 0)
                            <div class="col-md-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        Имя заказчика : {{ $order->name  }}
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
                                                        onclick="setPoints({{$order->point_A}},{{$order->point_B}})">
                                                    <i class="fa fa-compass"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

            </div>

        </div>
    </div>

@endsection
@section('scripts')

@endsection