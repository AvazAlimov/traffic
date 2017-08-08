@extends('layouts.app')
@section('head')
    <!--suppress ALL -->
    <style>
        .section {
            display: none;
        }

        #navbar {
            margin: 0;
        }
    </style>
@endsection
@section('content')
    <nav class="navbar navbar-default" style="border-radius: 0; border-width: 0 0 thin 0;">
        <ul class="nav navbar-nav">
            <li data-toggle="tab" class="active"><a onclick="switchSection('section1')"><i class="fa fa-car"></i>
                    Автомобили</a></li>
            <li data-toggle="tab"><a onclick="switchSection('section2')"><i class="fa fa-users"></i> Операторы</a>
            </li>
            <li data-toggle="tab"><a onclick="switchSection('section3')"><i class="fa fa-money"></i> Цены</a></li>
            <li data-toggle="tab"><a onclick="switchSection('section4')"><i class="fa fa-file-excel-o"></i> Экспорт в
                    Excel</a></li>
        </ul>
    </nav>
    <div class="container" style="padding: 0 20px 20px 20px">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div id="section1" class="section" style="display: block;">
                    <div class="page-header">
                        <h2>Автомобили</h2>
                    </div>
                    @foreach ($automobiles as $automobile)
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <strong>{{ $automobile->name }}</strong>
                            </div>
                            <div class="panel-body">
                                <div class="media">
                                    <div class="media-left">
                                        <img id="price" src="{{ "automobile/".$automobile->image }}">
                                    </div>
                                    <div class="media-body">
                                        <h3 class="media-heading">{{ $automobile->price }} сум</h3>
                                        <p>{{ $automobile->info }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <table>
                                    <tbody>
                                    <tr>
                                        <td>
                                            <form action="{{ route('automobile.show', $automobile->id) }}"
                                                  method="get">
                                                <button type="submit" class="btn btn-primary pull-right">Изменить
                                                </button>
                                            </form>
                                        </td>
                                        <td>
                                            <form action="{{ route('automobile.delete', $automobile->id) }}"
                                                  method="post">
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger pull-right">Удалить</button>
                                            </form>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                    <form action="{{ route('automobile.create') }}" method="GET">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-primary pull-right">
                            Добавить автомобиль
                        </button>
                    </form>
                </div>
                <div id="section2" class="section">
                    <div class="page-header">
                        <h2>Операторы</h2>
                    </div>
                    @foreach ($operators as $operator)
                        <div class="col-md-6">

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <strong>{{ $operator->username }}</strong>
                                </div>
                                <div class="panel-body">
                                    <div class="media">
                                        <div class="media-left">
                                            <img src="{{ "operator_file/".$operator->image }}" class="img-circle"
                                                 style="width: 128px; height: 128px">
                                        </div>
                                        <div class="media-body">
                                            <h3 class="media-heading">Имя: {{ $operator->name }}</h3>
                                            <br>
                                            <p><strong>Создан:</strong> {{ $operator->created_at }}</p>
                                            <p><strong>Обновлен:</strong> {{ $operator->updated_at }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <table>
                                        <tbody>
                                        <tr>
                                            <td>
                                                <form action="{{ route('operator.show', $operator->id) }}" method="get">
                                                    {{ csrf_field() }}
                                                    <button type="submit" class="btn btn-primary pull-right">Изменить
                                                    </button>
                                                </form>
                                            </td>
                                            <td>
                                                <form action="{{ route('operator.delete', $operator->id) }}"
                                                      method="post">
                                                    {{ csrf_field() }}
                                                    <button type="submit" class="btn btn-danger pull-right">Удалить
                                                    </button>
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
                        <form action="{{ route('operator.create') }}" method="GET">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-primary pull-right">
                                Добавить оператор
                            </button>
                        </form>
                    </div>
                </div>
                <div id="section3" class="section">
                    <div class="page-header">
                        <h2>Цены</h2>
                    </div>
                    <div class="row">
                        @foreach ($tarifs as $tarif)
                            @if($tarif->type == 0)
                                <div class="col-md-6">
                                    <form class="for-horizontal"
                                          action="{{ route('tarif.update', $tarif->id)  }}" method="post">
                                        {{ csrf_field() }}
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <strong>Внутри города</strong>
                                            </div>
                                            <div class="panel-body">
                                                <div class="form-group col-md-12">
                                                    <label for="price_per_hour" class="col-md-6 control-label">Цена за
                                                        час:</label>
                                                    <div class="col-md-5">
                                                        <input id="price_per_hour" type="number" min="0"
                                                               class="form-control align-middle"
                                                               name="price_per_hour"
                                                               value="{{ $tarif->price_per_hour }}" required>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <p>сум</p>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="min_hour" class="col-md-6 control-label">Час по
                                                        умолчанию:</label>
                                                    <div class="col-md-5">
                                                        <input id="min_hour" type="number" min="0"
                                                               class="form-control"
                                                               name="min_hour"
                                                               value="{{ $tarif->min_hour }}" required>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="price_minimum" class="col-md-6 control-label">Начальная
                                                        цена:</label>
                                                    <div class="col-md-5">
                                                        <input id="price_minimum" type="number" min="0"
                                                               class="form-control"
                                                               name="price_minimum"
                                                               value="{{ $tarif->price_minimum }}" required>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <p>сум</p>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="price_per_person"
                                                           class="col-md-6 control-label">Плата за обслуживание
                                                        погрузчика:</label>
                                                    <div class="col-md-5">
                                                        <input id="price_per_person" type="number" min="0"
                                                               class="form-control"
                                                               name="price_per_person"
                                                               value="{{ $tarif->price_per_person }}" required>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <p>сум</p>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="discard"
                                                           class="col-md-6 control-label">Скидка:</label>
                                                    <div class="col-md-5">
                                                        <input id="discard" type="number" min="0"
                                                               class="form-control"
                                                               name="discard"
                                                               value="{{ $tarif->discard }}" required>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <p>%</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel-footer">
                                                <table>
                                                    <tbody>
                                                    <tr>
                                                        <td>
                                                            <input type="submit" class="btn btn-primary"
                                                                   value="Обновить">
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @else
                                <div class="col-md-6">
                                    <form class="for-horizontal"
                                          action="{{ route('tarif.update', $tarif->id)  }}" method="post">
                                        {{ csrf_field() }}
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <strong>За городом</strong>
                                            </div>
                                            <div class="panel-body">
                                                <div class="form-group col-md-12">
                                                    <label for="price_per_distance" class="col-md-6 control-label">Цена
                                                        за
                                                        км:</label>
                                                    <div class="col-md-5">
                                                        <input id="price_per_distance" type="number" min="0"
                                                               class="form-control align-middle"
                                                               name="price_per_distance"
                                                               value="{{ $tarif->price_per_distance }}" required>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <p>сум</p>
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label for="min_distance" class="col-md-6 control-label">Км по
                                                        умолчанию:</label>
                                                    <div class="col-md-5">
                                                        <input id="min_distance" type="number" min="0"
                                                               class="form-control"
                                                               name="min_distance"
                                                               value="{{ $tarif->min_distance }}" required>
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label for="price_minimum" class="col-md-6 control-label">Начальная
                                                        цена:</label>
                                                    <div class="col-md-5">
                                                        <input id="price_minimum" type="number" min="0"
                                                               class="form-control"
                                                               name="price_minimum"
                                                               value="{{ $tarif->price_minimum }}" required>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <p>сум</p>
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label for="price_per_person"
                                                           class="col-md-6 control-label">Плата за обслуживание
                                                        погрузчика:</label>
                                                    <div class="col-md-5">
                                                        <input id="price_per_person" type="number" min="0"
                                                               class="form-control"
                                                               name="price_per_person"
                                                               value="{{ $tarif->price_per_person }}" required>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <p>сум</p>
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label for="discard"
                                                           class="col-md-6 control-label">Скидка:</label>
                                                    <div class="col-md-5">
                                                        <input id="discard" type="number" min="0"
                                                               class="form-control"
                                                               name="discard"
                                                               value="{{ $tarif->discard }}" required>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <p>%</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel-footer">
                                                <table>
                                                    <tbody>
                                                    <tr>
                                                        <td>
                                                            <input type="submit" class="btn btn-primary"
                                                                   value="Обновить">
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div id="section4" class="section">
                    <div class="page-header">
                        <h2>Экспорт в Excel</h2>
                        <h3>Всего: {{ $orders->count() }}</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th># Ид</th>
                                <th>Заказал</th>
                                <th>Тип автомобиля</th>
                                <th>Кол-во грузчиков</th>
                                <th>Время подачи</th>
                                <th>Час/Дистанция(км)</th>
                                <th>Откуда</th>
                                <th>Куда</th>
                                <th>Имя заказчика</th>
                                <th>Телефон</th>
                                <th>Цена</th>
                                <th>Обслужил</th>
                                <th>Создан</th>
                                <th>Обновлен</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->user_type == 0 ? "Пользователь" : ($order->user_type == 1 ? "Юр-лицо" : "Оператор") }}
                                    </td>
                                    <td>{{ $order->automobile->name }}</td>
                                    <td>{{ $order->persons }}</td>
                                    <td>{{ $order->start_time }}</td>
                                    <td>{{ $order->unit }}</td>
                                    <td>{{ $order->address_A }}</td>
                                    <td>{{ $order->address_B }}</td>
                                    <td>{{ $order->name }}</td>
                                    <td>{{ $order->phone }}</td>
                                    <td>{{ $order->sum }}</td>
                                    <td>{{ $order->operator != null ? $order->operator->username : "" }}</td>
                                    <td>Создан</td>
                                    <td>Обновлен</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function switchSection(id) {
            var section = document.getElementsByClassName('section');
            for (var i = 0; i < section.length; i++)
                section[i].style.display = "none";
            document.getElementById(id).style.display = "block";
        }
    </script>
@endsection
