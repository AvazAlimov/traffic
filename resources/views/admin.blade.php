@extends('layouts.app')
@section('head')
    <!--suppress ALL -->
    <style>
        @media screen and (max-width: 770px) {
            .navs {
                left: 10px;
            }
        }

        .section {
            display: none;
        }

        #navbar {
            display: none;
            margin: 0;
        }

        td {
            border-right: solid 1px #aaa;
            border-left: solid 1px #aaa;
            border-bottom: solid 1px #aaa;
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
    <nav class="navbar navbar-default" id="navigation"
         style="border-radius: 0; border-width: 0 0 thin 0; display: none;">
        <ul class="nav navbar-nav">
            <li data-toggle="tab" class="navs"><a onclick="switchSection('section1')"><i class="fa fa-car"></i>
                    Автомобили</a></li>
            <li data-toggle="tab" class="navs"><a onclick="switchSection('section2')"><i class="fa fa-users"></i>
                    Операторы</a>
            </li>
            <li data-toggle="tab" class="navs"><a onclick="switchSection('section3')"><i class="fa fa-money"></i>
                    Цены</a></li>
            <li data-toggle="tab" class="navs"><a onclick="switchSection('section4')"><i class="fa fa-file-excel-o"></i>
                    Экспорт в
                    Excel</a></li>
        </ul>
    </nav>
    <div class="container-fluid" id="container" style="padding: 0 20px 20px 20px; display: none;">
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
                    <h3>Грузоперевозки</h3>
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
                    <br>
                    <h3>Такси</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <form class="for-horizontal"
                                  action="{{ route('taxitarif.update', $taxiTarif->id)  }}" method="post">
                                {{ csrf_field() }}
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <strong>Единый тариф</strong>
                                    </div>
                                    <div class="panel-body">
                                        <div class="form-group col-md-12">
                                            <label for="price_per_distance" class="col-md-6 control-label">Цена за
                                                км:</label>
                                            <div class="col-md-5">
                                                <input id="price_per_distance" type="number" min="0"
                                                       class="form-control align-middle"
                                                       name="price_per_distance"
                                                       value="{{ $taxiTarif->price_per_distance }}" required>
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
                                                       class="form-control align-middle"
                                                       name="min_distance"
                                                       value="{{ $taxiTarif->min_distance }}" required>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="price_per_minute" class="col-md-6 control-label">Цена за
                                                минуту:</label>
                                            <div class="col-md-5">
                                                <input id="price_per_minute" type="number" min="0"
                                                       class="form-control align-middle"
                                                       name="price_per_minute"
                                                       value="{{ $taxiTarif->price_per_minute }}" required>
                                            </div>
                                            <div class="col-md-1">
                                                <p>сум</p>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="min_minute" class="col-md-6 control-label">Минута по
                                                умолчанию:</label>
                                            <div class="col-md-5">
                                                <input id="min_minute" type="number" min="0"
                                                       class="form-control"
                                                       name="min_minute"
                                                       value="{{ $taxiTarif->min_minute }}" required>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="price_minimum" class="col-md-6 control-label">Начальная
                                                цена:</label>
                                            <div class="col-md-5">
                                                <input id="price_minimum" type="number" min="0"
                                                       class="form-control"
                                                       name="price_minimum"
                                                       value="{{ $taxiTarif->price_minimum }}" required>
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
                    </div>
                </div>
                <div id="section4" class="section">
                    <div class="page-header">
                        <h2>Экспорт в Excel</h2>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">Всего принятых заказов {{ $orders->count() }}</div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr style="white-space: nowrap;">
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
                                        <tr style="white-space: nowrap;">
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
                                            <td>{{ $order->created_at }}</td>
                                            <td>{{ $order->updated_at }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a type="button" class="btn btn-success" href="{{ route('admin.order.excel') }}">Скачать</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="loader"></div>
    <script>
        function switchSection(id) {
            document.cookie = "page=" + id + ";";
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

        window.onload = function () {
            switchSection(getCookie("page"));
            var navs = document.getElementsByClassName("navs");
            navs[getCookie("page").replace("section", "") - 1].className = "navs active";
            document.getElementById("loader").style.display = "none";
            document.getElementById("navigation").style.display =
                    document.getElementById("container").style.display =
                            document.getElementById("navbar").style.display = "block";
        }
    </script>
@endsection
