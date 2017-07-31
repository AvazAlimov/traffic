@extends('layouts.main')
@section('styles')

@endsection
@section('content')
    <div class="container" id="order" style="padding: 100px 15px;">
        {{Form::open(['route' => ['user.order.submit'], 'method'=>'post'])}}
        {{csrf_field()}}
        <div class="panel panel-default">
            <div class="panel-heading" style="background-color: #372e30; color: #ffcb08;">
                <h4>СДЕЛАТЬ ЗАКАЗ</h4>
            </div>
            <div class="panel-body">
                <div class="col-md-6">
                    <div class="form-group col-md-12">
                        <label for="tarif" class="col-md-4">Тариф:</label>
                        <div class="col-md-8">
                            {{Form::select('tarif', $tarif, null, ['class'=>'form-control', 'onchange'=>'changeTarif()', 'id'=>'tarif_id'])}}
                        </div>
                    </div>

                    <div class="col-md-12">
                        <hr>
                    </div>

                    <div class="form-group col-md-12">
                        <label class="col-md-4">Тип автомобиля:</label>
                        <div class="col-md-8">
                            {{Form::select('car', $car, null, ['class'=>'form-control', 'onchange' => 'changeCar()', 'id' => 'car_id'])}}
                        </div>
                    </div>
                    <div class="form-group col-md-12 text-center">
                        <img id="car_image" src="{{asset('automobile/'.$cars[0]->image)}}" data-toggle="modal"
                             data-target="#carModal" onclick="showAutoInfo()">
                        <p style="margin-top: 10px;">Нажмите на автомобиль чтобы увидеть информацию об автомобиле</p>
                    </div>

                    <div class="col-md-12">
                        <hr>
                    </div>

                    <div class="form-group col-md-12">
                        <label class="col-md-4">Количество грузчиков:</label>
                        <div class="col-md-8">
                            {{Form::number('persons', 0, ['max' => 8, 'min'=>0, 'class'=>'form-control', 'id' =>'person_id', 'onchange' => 'personsChange()'])}}
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="date_id" class="col-md-4">Время подачи:</label>
                        <div class="col-md-5">
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
                        <label for="unit_id" id="label_tarif" class="col-md-4">Срок аренды (час):</label>
                        <div class="col-md-8">
                            <input name="unit" type="number"
                                   value="{{ $tarifs[0]->min_hour  }}" min="{{ $tarifs[0]->min_hour  }}"
                                   class="form-control" required id="unit_id"
                                   onchange="unitChange()">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    @if ($errors->has('point_A'))
                        <div class="col-md-12">
                                            <span class="help-block">
                                                <strong class="alert-danger">{{ $errors->first('point_A') }}</strong>
                                            </span>
                        </div>
                    @endif
                    <div class="form-group col-md-12">

                        <label class="col-md-3">Откуда:</label>
                        <div class="col-md-8">
                            {{Form::text('address_A',null, ['class'=>'form-control', 'id'=>'address_a', 'readOnly'])}}
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-default" data-toggle="modal"
                                    data-target="#firstMapModal" onclick="setStartPoint()"><i class="fa fa-compass"></i>
                            </button>
                        </div>
                    </div>
                    @if ($errors->has('point_B'))
                        <div class="col-md-12">
                                            <span class="help-block">
                                                <strong class="alert-danger">{{ $errors->first('point_B') }}</strong>
                                            </span>
                        </div>
                    @endif
                    <div class="form-group col-md-12">

                        <label class="col-md-3">Куда:</label>
                        <div class="col-md-8">
                            {{Form::text('address_B',null, ['class'=>'form-control', 'id'=>'address_b', 'readOnly'])}}
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-default" data-toggle="modal"
                                    data-target="#firstMapModal" onclick="setEndPoint()"><i class="fa fa-compass"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col-md-4">
                        {{Form::hidden('point_A',null, ['id'=>'point_a', 'class'=>'form-control'])}}
                    </div>
                    <div class="col-md-4">
                        {{Form::hidden('point_B',null,['id'=>'point_b', 'class'=>'form-control'])}}
                    </div>

                    <div class="col-md-12">
                        <hr>
                    </div>
                    @if ($errors->has('name'))
                        <div class="col-md-4">
                        <span class="help-block">
                            <strong class="alert-danger">{{ $errors->first('name') }}</strong>
                        </span>
                        </div>
                    @endif
                    <div class="form-group col-md-12">

                        <label class="col-md-3">Имя заказчика:</label>
                        <div class="col-md-9">
                            {{Form::text('name', Auth::guard('web')->user()->name,['class'=>'form-control'])}}
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
                        <label class="col-md-3">Телефон:</label>
                        <div class="col-md-9">
                            {{Form::text('phone','+'.Auth::guard('web')->user()->phone,['class'=>'form-control'])}}
                        </div>
                    </div>

                    <div class="col-md-12">
                        <hr>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="discount_id" class="col-md-3">Скидка:</label>
                        <div class="col-md-3">
                            {{Form::number('discount', $tarifs[0]->discard, ['id' => 'discount_id', 'class' => 'form-control', 'readonly'])}}
                        </div>
                        <div class="col-md-1">
                            <label>%</label>
                        </div>
                        <div class="col-md-4">
                            {{Form::number('discount', 0, ['id' => 'sum_discount_id', 'class' => 'form-control', 'readonly'])}}
                        </div>
                        <div class="col-md-1">
                            <label>сум</label>
                        </div>
                    </div>

                    <div class="form-group col-md-12">
                        <label class="col-md-3">Цена:</label>
                        <div class="col-md-8">
                            {{Form::number('sum',null, ['class'=>'form-control', 'id'=>'sum_id', 'readOnly'])}}
                        </div>
                        <label class="col-md-1">
                            сум
                        </label>
                    </div>

                    <div class="col-md-12">
                        <hr>
                    </div>

                    <div class="col-md-12">
                        <button type="submit" class="btn btn-block"
                                style="background-color: #372e30; color: #ffcb08; font-size: 18px;">
                            ЗАКАЗАТЬ
                        </button>
                    </div>
                </div>
            </div>
        </div>
        {{Form::close()}}

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

        <div class="modal fade" id="firstMapModal" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" style="border-radius: 0;">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"
                                style="color: #ffcb08;">&times;</button>
                        <h4 class="modal-title">Карта</h4>
                    </div>
                    <div class="modal-body" style="height: 500px; padding: 0; background-color: #372e30;">
                        <div id="firstMap" class="col-md-12" style="height: 500px;"></div>
                    </div>
                    <div class="modal-footer" style="background-color: #372e30;">
                        <button type="button" class="btn btn-default" data-dismiss="modal"
                                style="background-color: #ffcb08; color: #0d3625;">Закрыт
                        </button>
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
            <h3>Всего заказов: {{$orders->count()}}</h3>
            @foreach($orders as $order)
                <div class="col-md-6">
                    <div class="panel panel-default"
                         style="border: 1px solid {{ $order->status == 0 ? "#372e30" : ($order->status == -1 ? "#EF5350" : "#66BB6A") }}">
                        <div class="panel-heading"
                             style="color: white; background-color: {{ $order->status == 0 ? "#372e30" : ($order->status == -1 ? "#EF5350" : "#66BB6A") }}">
                            <strong>Идентификационный номер
                                заказа: {{ $order->id }} {{ $order->status == 0 ? "- В процессе" : ($order->status == -1 ? " - Отменен" : " - Принят") }}</strong>
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
                                <div class="col-md-8">{{ $order->name }}</div>
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
                                            data-target="#secondMapModal"
                                            onclick="setPoints({{$order->point_A}} + '',{{$order->point_B}} + '')">
                                        <i class="fa fa-compass"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer"
                             style="color: white; background-color: {{ $order->status == 0 ? "#372e30" : ($order->status == -1 ? "#EF5350" : "#66BB6A") }}">
                            <table>
                                <tbody>
                                <tr>
                                    <td>
                                        <form method="get"
                                              action="{{route('user.order.again', $order->id)}}">
                                            {{csrf_field()}}
                                            <input type="submit" class="btn btn-default"
                                                   value="Заказать снова">
                                        </form>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="col-md-12 text-center">
                {{$orders->links()}}
            </div>
        </div>

        <div class="modal fade" id="secondMapModal" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" style="border-radius: 0;">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"
                                style="color: #ffcb08;">&times;</button>
                        <h4 class="modal-title">Карта</h4>
                    </div>
                    <div class="modal-body" style="height: 500px; padding: 0; background-color: #372e30;">
                        <div id="secondMap" class="col-md-12" style="height: 500px;"></div>
                    </div>
                    <div class="modal-footer" style="background-color: #372e30;">
                        <button type="button" class="btn btn-default" data-dismiss="modal"
                                style="background-color: #ffcb08; color: #0d3625;">Закрыт
                        </button>
                    </div>
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
                        <li style="display: inline; margin: 4px;"><a href="#"><i class="fa fa-rss" aria-hidden="true"
                                                                                 style="font-size: 32px; color: #ffcb08;"></i></a>
                        </li>
                        <li style="display: inline; margin: 4px;"><a href="#"><i class="fa fa-google-plus"
                                                                                 aria-hidden="true"
                                                                                 style="font-size: 32px; color: #ffcb08;"></i></a>
                        </li>
                        <li style="display: inline; margin: 4px;"><a href="#"><i class="fa fa-linkedin"
                                                                                 aria-hidden="true"
                                                                                 style="font-size: 32px; color: #ffcb08;"></i></a>
                        </li>
                        <li style="display: inline; margin: 4px;"><a href="#"><i class="fa fa-skype" aria-hidden="true"
                                                                                 style="font-size: 32px; color: #ffcb08;"></i></a>
                        </li>
                        <li style="display: inline; margin: 4px;"><a href="#"><i class="fa fa-vimeo" aria-hidden="true"
                                                                                 style="font-size: 32px; color: #ffcb08;"></i></a>
                        </li>
                        <li style="display: inline; margin: 4px;"><a href="#"><i class="fa fa-tumblr" aria-hidden="true"
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
    <script>
        var baseUrl = '{{ URL::asset("") }}';
        automobiles = {!! $cars !!};

        function showAutoImage() {
            document.getElementById('car_image').src = baseUrl + "automobile/" + automobiles[document.getElementById('car_id').selectedIndex]['image'];
        }

        function showAutoInfo() {
            var info = automobiles[document.getElementById('car_id').selectedIndex]['info'];
            var rows = 0;
            for (var i = 0; i < info.length; i++)
                if (info[i] === '\n')
                    rows++;
            document.getElementById('automobile_info').rows = rows + 4;
            document.getElementById('automobile_info').innerHTML = info;
        }

        var firstMap;
        var secondMap;
        var startPoint = false;
        var endPoint = false;
        var path;

        ymaps.ready(init);

        function init() {
            secondMap = new ymaps.Map("secondMap", {
                center: [41.299496, 69.240073],
                zoom: 13,
                controls: []
            }, {searchControlProvider: 'yandex#search'});

            secondMap.controls.add('geolocationControl');
            secondMap.controls.add('searchControl');
            secondMap.controls.add('zoomControl');
            secondMap.controls.get('searchControl').options.set('size', 'large');

            firstMap = new ymaps.Map("firstMap", {
                center: [41.299496, 69.240073],
                zoom: 13,
                controls: []
            }, {searchControlProvider: 'yandex#search'});

            firstMap.controls.add('geolocationControl');
            firstMap.controls.add('searchControl');
            firstMap.controls.add('zoomControl');
            firstMap.controls.get('searchControl').options.set('size', 'large');

            firstMap.events.add('click', function (event) {
                var coords = event.get('coords');
                if (startPoint === false) {
                    startPoint = new ymaps.Placemark(coords, {
                        balloonContent: 'Пункт А'
                    }, {
                        draggable: true,
                        preset: 'islands#redHomeIcon',
                        iconColor: '#F44336'
                    });

                    firstMap.geoObjects.add(startPoint);

                    startPoint.events.add('dragend', function (e) {
                        setPoint(startPoint, 'address_a', 'point_a');
                    });

                    setPoint(startPoint, "address_a", "point_a");
                    return;
                }
                if (endPoint === false) {
                    endPoint = new ymaps.Placemark(coords, {
                        balloonContent: 'Пункт Б'
                    }, {
                        draggable: true,
                        preset: 'islands#redGovernmentIcon',
                        iconColor: '#F44336'
                    });

                    firstMap.geoObjects.add(endPoint);

                    endPoint.events.add('dragend', function (e) {
                        setPoint(endPoint, 'address_b', 'point_b');
                    });
                    setPoint(endPoint, "address_b", "point_b");
                }
            });
        }

        function setPoint(placemark, id_address, id_point) {
            var coords = placemark.geometry.getCoordinates();
            ymaps.geocode(coords).then(function (res) {
                var firstGeoObject = res.geoObjects.get(0);
                document.getElementById(id_address).value = firstGeoObject.getAddressLine();
            });
            document.getElementById(id_point).value = coords;
            drawPath();
        }

        function drawPath() {
            if (startPoint === false || startPoint === false)
                return;

            firstMap.geoObjects.remove(path);

            ymaps.route([startPoint.geometry.getCoordinates(), endPoint.geometry.getCoordinates()], {
                mapStateAutoApply: true,
                multiRoute: false
            }).then(function (route) {
                        path = route;
                        distance = (route.getLength() / 1000).toFixed(2);
                        if (tarifs[tarif_index]['type'] === 1) {
                            document.getElementById('unit_id').value = distance;
                            calculatePrice();
                        }
                        firstMap.geoObjects.add(route);
                        path.getWayPoints().removeAll();
                    }, function (error) {
                        alert("Возникла ошибка: " + error.message);
                    }
            );
        }

        function setStartPoint() {
            document.getElementById('point_a').value = document.getElementById('address_a').value = "";
            firstMap.geoObjects.remove(startPoint);
            firstMap.geoObjects.remove(path);
            startPoint = false;
        }

        function setEndPoint() {
            document.getElementById('point_b').value = document.getElementById('address_b').value = "";
            firstMap.geoObjects.remove(endPoint);
            firstMap.geoObjects.remove(path);
            endPoint = false;
        }

        var tarifs = {!! $tarifs !!};
        var tarif_index = 0;
        var car_index = 0;
        var hour = 0;
        var distance = 0;
        var min_price = 0;
        var price_for_unit;
        var min_price_unit;
        var price_per_person;
        var discount = 0;
        var car_price = 0;
        var persons = 0;

        function changeTarif() {
            tarif_index = document.getElementById('tarif_id').selectedIndex;
            var unit = document.getElementById('unit_id');
            if (tarifs[tarif_index]['type'] === 0) {
                unit.min = tarifs[tarif_index]['min_hour'];
                unit.value = tarifs[tarif_index]['min_hour'] > hour ? tarifs[tarif_index]['min_hour'] : hour;
                unit.readOnly = false;
                price_for_unit = tarifs[tarif_index]['price_per_hour'];
                min_price_unit = tarifs[tarif_index]['min_hour'];
                document.getElementById('label_tarif').innerHTML = 'Срок аренды (час):';
            } else {
                unit.min = tarifs[tarif_index]['min_distance'];
                unit.value = tarifs[tarif_index]['min_distance'] > distance ? tarifs[tarif_index]['min_distance'] : distance;
                unit.readOnly = true;
                price_for_unit = tarifs[tarif_index]['price_per_distance'];
                min_price_unit = tarifs[tarif_index]['min_distance'];
                document.getElementById('label_tarif').innerHTML = 'Дистанция (км):';
            }
            min_price = tarifs[tarif_index]['price_minimum'];
            price_per_person = tarifs[tarif_index]['price_per_person'];
            document.getElementById('discount_id').value = discount = tarifs[tarif_index]['discard'];

            calculatePrice();
        }

        function changeCar() {
            car_index = document.getElementById('car_id').selectedIndex;
            car_price = automobiles[car_index]['price'];
            showAutoImage();
            calculatePrice();
        }

        function personsChange() {
            persons = document.getElementById('person_id').value;
            calculatePrice();
        }

        function unitChange() {
            calculatePrice();
        }

        function calculatePrice() {
            var price = min_price;
            price += car_price;
            price += price_for_unit * (document.getElementById('unit_id').value - min_price_unit);
            price += persons * price_per_person;

            price -= (document.getElementById('sum_discount_id').value = (price * (discount / 100))).toFixed(0);
            document.getElementById('sum_id').value = price;
        }

        function setPoints(point_a_1, point_a_2, point_b_1, point_b_2) {
            var point_a = point_a_1 + "," + point_a_2;
            var point_b = point_b_1 + "," + point_b_2;
            secondMap.geoObjects.removeAll();
            ymaps.route([point_a, point_b], {
                mapStateAutoApply: true,
                multiRoute: false
            }).then(function (route) {
                        secondMap.geoObjects.add(route);
                    }, function (error) {
                        alert("Error occurred: " + error.message);
                    }
            );
        }

        window.onload = function () {
            tarif_index = document.getElementById('tarif_id').selectedIndex = 0;
            car_index = document.getElementById('car_id').selectedIndex = 0;
            changeTarif();
            changeCar();
        }
    </script>
@endsection