@extends('layouts.app')
@section('head')
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
                    <form action="{{ route('operator.taxiorder.update.submit', $order->id) }}" method="post">
                        {{csrf_field()}}
                        <div class="form-group col-md-12">
                            <label for="taxi_minute" class="col-md-3">
                                Время ожидание:
                            </label>
                            <div class="col-md-2">
                                <input type="number" name="minute" class="form-control"
                                       id="taxi_minute" onchange="calculateTaxiPrice()"
                                       min="{{ $taxi_tariff->min_minute }}"
                                       value="{{ $order->minute }}">
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
                                       id="taxi_distance" min="0" step="2" value="{{ $order->distance }}" readonly>
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
                                       value="{{ DateTime::createFromFormat('Y-m-d H:i:s', $order->start_time)
                                       ->format('Y-m-d H:i') }}"
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
                                       class="form-control" value="{{ $order->name }}">
                            </div>
                        </div>

                        <div class="form-group col-md-12 {{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label for="taxi_phone" class="col-md-3">
                                Телефон заказчика:
                            </label>
                            <div class="col-md-9">
                                <input type="text" name="phone" id="taxi_phone"
                                       class="form-control" value="{{ $order->phone }}">
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
                                       name="price" value="{{ $order->price }}">
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
@endsection
@section('scripts')
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
    <script src="{{ asset("js/bootstrap-datetimepicker.js") }}"></script>
    <!--suppress JSUnresolvedVariable, JSUnresolvedFunction -->
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
                    document.getElementById("taxi_address_a").value = firstGeoObject.getAddressLine();
                    document.getElementById("taxi_point_a").value = coords;
                }
                if (placemark === endPoint) {
                    document.getElementById("taxi_address_b").value = firstGeoObject.getAddressLine();
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
                        document.getElementById("taxi_distance").value = distance;
                        calculateTaxiPrice()
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
                document.getElementById("taxi_address_a").value =
                        document.getElementById("taxi_point_a").value = "";
            }
        }

        function setEndPoint() {
            if (endPoint !== false) {
                navigationMap.geoObjects.remove(endPoint);
                navigationMap.geoObjects.remove(path);
                endPoint = false;
                document.getElementById("taxi_address_b").value =
                        document.getElementById("taxi_point_b").value = "";
            }
        }

        ymaps.ready(initMaps);
        //----- Maps Scripts End -----//

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
            calculateTaxiPrice();
        };
    </script>
@endsection