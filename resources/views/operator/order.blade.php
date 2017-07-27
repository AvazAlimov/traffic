@extends('layouts.app')
@section('head')
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="col-md-8 col-md-offset-2">
            {{Form::model($order, ['route' => ['operator.order.update.submit', $order->id], 'method' => 'post'])}}
            <div class="panel panel-default">
                <div class="panel-heading">Order</div>
                <div class="panel-body">
                    <div class="form-group col-md-12">
                        <label class="col-md-2"> Tarif</label>
                        <div class="col-md-10">
                            {{Form::select('tarif', $tarif,$order->tarif->id, ['class'=>'form-control', 'onchange'=>'changeTarif()', 'id'=>'tarif_id'])}}
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label class="col-md-2"> Car</label>
                        <div class="col-md-10">
                            {{Form::select('car', $car, $order->automobile->id,['class'=>'form-control', 'onchange' => 'changeCar()', 'id' => 'car_id'])}}
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label class="col-md-2">Persons</label>
                        <div class="col-md-10">
                            {{Form::number('persons', null,['max' => 8, 'min'=>0, 'class'=>'form-control', 'id' =>'person_id', 'onchange' => 'personsChange()'])}}
                        </div>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="date_id" class="col-md-2"> Start Time</label>
                        <div class="col-md-7">
                            <input type="date" value="{{ Carbon\Carbon::parse($order->start_time)->format('Y-m-d')}}" name="date" class="form-control"
                                   id="date_id">
                        </div>
                        <div class="col-md-3">
                            <input type="time"
                                   value="{{Carbon\Carbon::parse($order->start_time)->format('H:i') }}" name="time"
                                   class="form-control" id="date_id">
                        </div>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="unit_id" id="label_tarif" class="col-md-2">Unit</label>
                        <div class="col-md-10">
                            <input name="unit" type="number" step="0.01" value="{{ $order->unit  }}" min="0.0"
                                   class="form-control" required id="unit_id" onchange="unitChange()">
                        </div>
                    </div>

                    @if ($errors->has('point_A'))
                        <div class="col-md-4">
                            <span class="help-block">
                                       <strong class="alert-danger">{{ $errors->first('point_A') }}</strong>
                            </span>
                        </div>
                    @endif
                    <div class="form-group col-md-12">
                        <label class="col-md-2"> From </label>
                        <div class="col-md-9">
                            {{Form::text('address_A',$order->address_A, ['class'=>'form-control', 'id'=>'address_a'])}}
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal"
                                    onclick="setStart()"><i class="fa fa-compass"></i></button>
                        </div>
                    </div>

                    @if ($errors->has('point_B'))
                        <div class="col-md-4">
                            <span class="help-block">
                                        <strong class="alert-danger">{{ $errors->first('point_B') }}</strong>
                            </span>
                        </div>
                    @endif
                    <div class="form-group col-md-12">
                        <label class="col-md-2"> To </label>
                        <div class="col-md-9">
                            {{Form::text('address_B',$order->address_B, ['class'=>'form-control', 'id'=>'address_b'])}}
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal"
                                    onclick="setEnd()"><i class="fa fa-compass"></i></button>
                        </div>
                    </div>

                    <div class="col-md-4">
                        {{Form::hidden('point_A',$order->point_A, ['id'=>'point_a', 'class'=>'form-control'])}}
                    </div>
                    <div class="col-md-4">
                        {{Form::hidden('point_B',$order->point_B,['id'=>'point_b', 'class'=>'form-control'])}}
                    </div>


                    <div class="form-group col-md-12">
                        <label for="discount_id" class="col-md-2">Discount</label>
                        <div class="col-md-10">
                            {{Form::number('discount', $order->tarif->discard, ['id' => 'discount_id', 'class' => 'form-control', 'readonly'])}}
                        </div>
                    </div>

                    <div class="form-group col-md-12">
                        <label class="col-md-2">Price</label>
                        <div class="col-md-10">
                            {{Form::number('sum',$order->sum, ['class'=>'form-control', 'id'=>'sum_id'])}}
                        </div>
                    </div>


                    @if ($errors->has('name'))
                        <div class="col-md-4">
                            <span class="help-block">
                                <strong class="alert-danger">{{ $errors->first('name') }}</strong>
                            </span>
                        </div>
                    @endif
                    <div class="form-group col-md-12">
                        <label class="col-md-2"> Name</label>
                        <div class="col-md-10">
                            {{Form::text('name',$order->name,['class'=>'form-control'])}}
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
                        <label class="col-md-2"> Phone</label>
                        <div class="col-md-10">
                            {{Form::text('phone',$order->phone,['class'=>'form-control'])}}
                        </div>
                    </div>

                </div>

                <div class="panel-footer">
                    <input type="submit" class="btn btn-success" value="Done">
                </div>

            </div>

            {{Form::close()}}
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
                    <button type="button" class="btn btn-default" data-dismiss="modal">Сохранить</button>
                </div>
            </div>
        </div>
    </div>

    <script>
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
            myMap = new ymaps.Map("map", {
                center: [41.299496, 69.240073],
                zoom: 13,
                controls: []
            }, {searchControlProvider: 'yandex#search'});
            myMap.controls.add('geolocationControl')
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
                document.getElementById('label_tarif').innerHTML = "Hours";
                document.getElementById('unit_id').min = tarifs[tarif_index]['min_hour'];
                document.getElementById('unit_id').value = tarifs[tarif_index]['min_hour'];
                document.getElementById('unit_id').readOnly = false;
            }
            else {
                document.getElementById('label_tarif').innerHTML = "Kilometers";
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
    </script>
@endsection