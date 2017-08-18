@extends('layouts.app')
@section('head')
    <!--suppress JSUnresolvedVariable, JSUnresolvedFunction -->
    <link rel="stylesheet" href="{{ asset("css/bootstrap-datetimepicker.css") }}">
    <style>
        label {
            margin-top: 5px;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Идентификационный номер: {{ $order->id }}
                </div>
                <div class="panel-body">
                    <form action="{{ route('operator.order.update.submit', $order->id) }}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group col-md-12">
                            <label for="trucking_tariff_id" class="col-md-3">
                                Выберите тариф:
                            </label>
                            <div class="col-md-9">
                                <select name="tariff_id" id="trucking_tariff_id"
                                        class="form-control" onchange="changeTariff()">
                                    @foreach($tariff as $index=>$tarif)
                                        <option value="{{ $index }}">{{ $tarif }}</option>
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
                                       id="trucking_loaders" min="0" max="8" value="{{ $order->persons }}"
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
                                       value="{{ DateTime::createFromFormat('Y-m-d H:i:s', $order->start_time)
                                       ->format('Y-m-d H:i') }}"
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
                                       class="form-control" value="{{ $order->name }}">
                            </div>
                        </div>

                        <div class="form-group col-md-12 {{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label for="trucking_phone" class="col-md-3">
                                Телефон заказчика:
                            </label>
                            <div class="col-md-9">
                                <input type="text" name="phone" id="trucking_phone"
                                       class="form-control" value="{{ $order->phone }}">
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
                                       name="price" value="{{ $order->sum }}">
                            </div>
                            <label class="col-md-1">сум</label>
                        </div>

                        <div class="col-md-12">
                            <hr>
                        </div>

                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success btn-block">
                                Изменить
                            </button>
                        </div>
                    </form>
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
@endsection
@section('scripts')
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
    <script src="{{ asset("js/bootstrap-datetimepicker.js") }}"></script>
    <script>
        $(".form_datetime").datetimepicker({format: 'yyyy-mm-dd hh:ii'});

        //----- Maps Scripts Start -----//
        var navigationMap;
        var startPoint = false;
        var endPoint = false;
        var distance = 0;
        var path;

        function initMaps() {
            navigationMap = new ymaps.Map("navigationMap", {
                center: [41.299496, 69.240073],
                zoom: 13,
                controls: []
            }, {searchControlProvider: 'yandex#search'});

            navigationMap.controls.add('geolocationControl');
            navigationMap.controls.add('searchControl');
            navigationMap.controls.add('zoomControl');
            navigationMap.controls.get('searchControl').options.set('size', 'large');

            startPoint = new ymaps.Placemark([{!! $order->point_A !!}], {
                balloonContent: 'Пункт А'
            }, {
                draggable: true,
                preset: 'islands#redHomeIcon',
                iconColor: '#F44336'
            });

            endPoint = new ymaps.Placemark([{!! $order->point_B !!}], {
                balloonContent: 'Пункт Б'
            }, {
                draggable: true,
                preset: 'islands#redGovernmentIcon',
                iconColor: '#F44336'
            });

            navigationMap.geoObjects.add(startPoint);
            navigationMap.geoObjects.add(endPoint);
            setPoint(startPoint);
            setPoint(endPoint);

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
                    document.getElementById("trucking_point_a").value = coords;
                }
                if (placemark === endPoint) {
                    document.getElementById("trucking_address_b").value = firstGeoObject.getAddressLine();
                    document.getElementById("trucking_point_b").value = coords;
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
                        calculateTruckingPrice();
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
                document.getElementById("trucking_address_a").value =
                        document.getElementById("trucking_point_a").value = "";
            }
        }

        function setEndPoint() {
            if (endPoint !== false) {
                navigationMap.geoObjects.remove(endPoint);
                navigationMap.geoObjects.remove(path);
                endPoint = false;
                document.getElementById("trucking_address_b").value =
                        document.getElementById("trucking_point_b").value = "";
            }
        }

        ymaps.ready(initMaps);
        //----- Maps Scripts End -----//

        //----- Trucking Calculation Scripts Start -----//
        var arrays = [{!! $tariffs !!}];
        arrays.push({!! $automobiles !!});
        var tariff_index;
        var car_index;

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

        window.onload = function () {
            document.getElementById("trucking_tariff_id").selectedIndex = {{ $order->tarif->id }} + 0;
            document.getElementById("trucking_automobile_id").value = {{ $order->automobile->id }} + '';
            document.getElementById("trucking_hour").value = {{ $order->unit }} + 0;
            car_index = document.getElementById("trucking_automobile_id").selectedIndex;
            changeTariff();
        };
    </script>
@endsection