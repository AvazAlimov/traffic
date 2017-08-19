@extends('layouts.main')
@section('styles')
    <!--suppress ALL -->
    <link rel="stylesheet" href="{{ asset("css/bootstrap-datetimepicker.css") }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style>
        @media (max-width: 978px) {
            .panel-body {
                padding: 0;
            }

            #submit_button {
                margin: 16px;
            }

            hr {
                display: none;
            }

            p {
                font-size: 12px;
            }

            label {
                margin: 0;
                padding: 0;
                font-size: 13px;
            }
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid" id="order" style="padding: 100px 15px;
            background-image: url('{{ asset('/resources/map.svg') }}');
            background-size: cover;">
        <div class="container">
            <div class="panel panel-default">
                <div class="panel-heading" style="background-color: #372e30; color: #ffcb08;">
                    <h4>
                        СДЕЛАТЬ ЗАКАЗ НА
                    </h4>
                    <div class="btn-group" data-toggle="buttons">
                        <button class="btn btn-warning active" data-toggle="tab"
                                data-target="#trucking" style="color: #372e30;">
                            ГРУЗОПЕРЕВОЗКУ
                        </button>
                        <button class="btn btn-warning" data-toggle="tab"
                                data-target="#taxi" style="color: #372e30;">
                            ТАКСИ
                        </button>
                    </div>
                </div>
                <div class="panel-body tab-content">
                    <div class="tab-pane active" id="trucking">
                        <form action="{{ route('user.order.submit') }}" method="post">
                            {{ csrf_field() }}
                            <div class="col-md-6">
                                <div class="form-group col-md-12">
                                    <label for="trucking_tariff_id" class="col-md-4">
                                        Тариф:
                                    </label>
                                    <div class="col-md-8">
                                        <select name="tariff_id" id="trucking_tariff_id"
                                                class="form-control" onchange="changeTariff()">
                                            @foreach($tariff as $index=>$item)
                                                <option value="{{$index}}">{{ $item}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="trucking_automobile_id" class="col-md-4">
                                        Тип автомобиля:
                                    </label>
                                    <div class="col-md-8">
                                        <select name="automobile_id" id="trucking_automobile_id"
                                                class="form-control" onchange="changeAutomobile()">
                                            @foreach($automobile as $index => $auto)
                                                <option value="{{$index}}">{{ $auto }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-12 text-center">
                                    <img id="car_image" src="{{asset('automobile/'.$automobiles[0]->image)}}"
                                         data-toggle="modal"
                                         data-target="#carModal" onclick="showAutoInfo()">
                                    <p style="margin-top: 10px;">Нажмите на автомобиль чтобы увидеть информацию об
                                        автомобиле</p>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="trucking_loaders" class="col-md-5">
                                        Количество грузчиков:
                                    </label>
                                    <div class="col-md-3">
                                        <input type="number" name="loaders" class="form-control"
                                               id="trucking_loaders" min="0" max="8" value="0"
                                               onchange="calculateTruckingPrice()">
                                    </div>
                                    <label class="col-md-1">человек</label>
                                </div>
                                <div class="form-group col-md-12" id="trucking_hour_wrapper">
                                    <label for="trucking_hour" class="col-md-5">
                                        Срок аренды:
                                    </label>
                                    <div class="col-md-3">
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
                                    <label for="trucking_distance" class="col-md-5">
                                        Дистанция:
                                    </label>
                                    <div class="col-md-3">
                                        <input type="number" name="distance" id="trucking_distance" step="2"
                                               class="form-control" min="0" value="0" readonly>
                                    </div>
                                    <label class="col-md-1">километр</label>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="trucking_start" class="col-md-5">
                                        Время подачи:
                                    </label>
                                    <div class="col-md-5">
                                        <input type="text" name="start"
                                               value="{{ \Carbon\Carbon::now()
                                                           ->setTimezone('Asia/Tashkent')
                                                           ->format("Y-m-d H:i") }}"
                                               class="form-control form_datetime"
                                               id="trucking_start" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
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

                                <div class="col-md-12">
                                    <hr>
                                </div>

                                <div class="form-group col-md-12 {{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="trucking_name" class="col-md-5">
                                        Имя заказчика:
                                    </label>
                                    <div class="col-md-7">
                                        <input type="text" name="name" id="trucking_name"
                                               class="form-control"
                                               value="{{ Illuminate\Support\Facades\Auth::guard('web')->user()->name }}">
                                    </div>
                                </div>

                                <div class="form-group col-md-12 {{ $errors->has('phone') ? ' has-error' : '' }}">
                                    <label for="trucking_phone" class="col-md-5">
                                        Телефон заказчика:
                                    </label>
                                    <div class="col-md-7">
                                        <input type="text" name="phone" id="trucking_phone"
                                               class="form-control"
                                               value="+{{ Illuminate\Support\Facades\Auth::guard('web')->user()->phone }}">
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="trucking_discard" class="col-md-3">
                                        Скидка:
                                    </label>
                                    <div class="col-md-3">
                                        <input type="number" id="trucking_discard" class="form-control"
                                               readonly>
                                    </div>
                                    <label class="col-md-1">%</label>
                                    <div class="col-md-4">
                                        <input type="number" id="trucking_discard_sum" class="form-control"
                                               readonly>
                                    </div>
                                    <label class="col-md-1">сум</label>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="trucking_price" class="col-md-5">
                                        Итоговая цена:
                                    </label>
                                    <div class="col-md-6">
                                        <input type="number" id="trucking_price" class="form-control"
                                               name="price" readonly>
                                    </div>
                                    <label class="col-md-1">сум</label>
                                </div>

                                <div class="col-md-12">
                                    <button type="button" class="btn btn-block"
                                            style="background-color: #ffcb08; color: #372e30; font-size: 18px;">
                                        ОЧИСТИТЬ
                                    </button>
                                    <button type="submit" class="btn btn-block"
                                            style="background-color: #372e30; color: #ffcb08; font-size: 18px;">
                                        ЗАКАЗАТЬ
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane" id="taxi">
                        <form action="{{ route('user.taxiorder.submit') }}" method="post">
                            {{csrf_field()}}
                            <div class="col-md-6">
                                <div class="form-group col-md-12">
                                    <label for="taxi_minute" class="col-md-4">
                                        Время ожидание:
                                    </label>
                                    <div class="col-md-3">
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
                                    <label for="taxi_distance" class="col-md-4">
                                        Дистанция:
                                    </label>
                                    <div class="col-md-3">
                                        <input type="number" name="distance" class="form-control"
                                               id="taxi_distance" min="0" step="2" value="0" readonly>
                                    </div>
                                    <label class="col-md-1">
                                        км
                                    </label>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="taxi_start" class="col-md-4">
                                        Время подачи:
                                    </label>
                                    <div class="col-md-5">
                                        <input type="text" name="start"
                                               value="{{ \Carbon\Carbon::now()
                                                           ->setTimezone('Asia/Tashkent')
                                                           ->format("Y-m-d H:i") }}"
                                               class="form-control form_datetime"
                                               id="taxi_start" readonly>
                                    </div>
                                </div>

                                <div class="form-group col-md-12 {{ ($errors->has('address_a') || $errors->has('point_a')) ? ' has-error' : '' }}">
                                    <label for="taxi_address_a" class="col-md-2">
                                        Откуда:
                                    </label>
                                    <div class="col-md-9">
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
                                    <label for="taxi_address_b" class="col-md-2">
                                        Куда:
                                    </label>
                                    <div class="col-md-9">
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
                            </div>
                            <div class="col-md-6">
                                <div class="form-group col-md-12 {{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="taxi_name" class="col-md-5">
                                        Имя заказчика:
                                    </label>
                                    <div class="col-md-7">
                                        <input type="text" name="name" id="taxi_name"
                                               class="form-control"
                                               value="{{ Illuminate\Support\Facades\Auth::guard('web')->user()->name }}">
                                    </div>
                                </div>

                                <div class="form-group col-md-12 {{ $errors->has('phone') ? ' has-error' : '' }}">
                                    <label for="taxi_phone" class="col-md-5">
                                        Телефон заказчика:
                                    </label>
                                    <div class="col-md-7">
                                        <input type="text" name="phone" id="taxi_phone"
                                               class="form-control"
                                               value="+{{ Illuminate\Support\Facades\Auth::guard('web')->user()->phone }}">
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="taxi_discard" class="col-md-3">
                                        Скидка:
                                    </label>
                                    <div class="col-md-3">
                                        <input type="number" id="taxi_discard" class="form-control"
                                               readonly value="{{ $taxi_tariff->discard }}">
                                    </div>
                                    <label class="col-md-1">%</label>
                                    <div class="col-md-4">
                                        <input type="number" id="taxi_discard_sum" class="form-control"
                                               readonly>
                                    </div>
                                    <label class="col-md-1">сум</label>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="taxi_price" class="col-md-5">
                                        Итоговая цена:
                                    </label>
                                    <div class="col-md-6">
                                        <input type="number" id="taxi_price" class="form-control"
                                               name="price" readonly>
                                    </div>
                                    <label class="col-md-1">сум</label>
                                </div>

                                <div class="col-md-12">
                                    <button type="button" class="btn btn-block"
                                            style="background-color: #ffcb08; color: #372e30; font-size: 18px;">
                                        ОЧИСТИТЬ
                                    </button>
                                    <button type="submit" class="btn btn-block"
                                            style="background-color: #372e30; color: #ffcb08; font-size: 18px;">
                                        ЗАКАЗАТЬ
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid" id="orders" style="background-color: white;">
        <div class="container" style="padding: 25px;">
            <div class="page-header">
                <h2>Все мои заказы</h2>
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

    <div class="modal fade" id="carModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="border-radius: 0;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            style="color: #ffcb08;">&times;</button>
                    <p class="modal-title">Автомобиль</p>
                </div>
                <div class="modal-body">
                    <textarea id="automobile_info" style="width: 100%; resize: none; border-width: 0;"
                              readonly></textarea>
                </div>
            </div>
        </div>
    </div>

    <footer class="container-fluid text-center" style="background-color: #372e30; padding: 50px;">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <ul style="list-style-type: none; margin: 0; padding: 0;">
                        <li style="display: inline; margin: 4px;"><a href="#"><i class="fa fa-facebook"
                                                                                 aria-hidden="true"
                                                                                 style="font-size: 32px; color: #ffcb08;"></i></a>
                        </li>
                        <li style="display: inline; margin: 4px;"><a href="#"><i class="fa fa-twitter"
                                                                                 aria-hidden="true"
                                                                                 style="font-size: 32px; color: #ffcb08;"></i></a>
                        </li>
                        <li style="display: inline; margin: 4px;"><a href="#"><i class="fa fa-google-plus"
                                                                                 aria-hidden="true"
                                                                                 style="font-size: 32px; color: #ffcb08;"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <p style="color: #ffcb08;">IUTLAB © All Rights Reserved</p>
                </div>
            </div>
            <br>
            <br>
            <br>
            <div class="col-md-12 col-sm-12">
                <h4 style="color: #ffcb08;">Ташкент 2017</h4>
            </div>
        </div>
    </footer>
@endsection
@section('scripts')
    <script src="{{ asset("js/bootstrap-datetimepicker.js") }}"></script>
    <script>
        $(".btn-group > .btn").click(function () {
            $(this).addClass("active").siblings().removeClass("active");
        });

        $(".form_datetime").datetimepicker({format: 'yyyy-mm-dd hh:ii'});

        var baseUrl = '{{ asset("") }}';

        function showAutoImage() {
            document.getElementById("car_image").src = baseUrl + "automobile/" + arrays[1][document.getElementById('trucking_automobile_id').selectedIndex]['image'];
        }

        function showAutoInfo() {
            var info = arrays[1][document.getElementById('trucking_automobile_id').selectedIndex]['info'];
            var rows = 0;
            for (var i = 0; i < info.length; i++)
                if (info[i] === '\n')
                    rows++;
            document.getElementById('automobile_info').rows = rows + 4;
            document.getElementById('automobile_info').innerHTML = info;
        }

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
        var tariff_index = 0;
        var car_index = 0;

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
            showAutoImage();
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
            document.getElementById("trucking_tariff_id").selectedIndex = 0;
            document.getElementById("trucking_automobile_id").selectedIndex = 0;
            changeTariff();
            changeAutomobile();
            calculateTaxiPrice();
        };
    </script>
@endsection