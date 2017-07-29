<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Traffic.uz</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>

    <style>
        .navbar {
            background-color: #372e30;
            margin-bottom: 0;
            z-index: 9999;
            border: 0;
            font-size: 12px !important;
            line-height: 1.42857143 !important;
            letter-spacing: 4px;
            border-radius: 0;
            font-family: Montserrat, sans-serif;
        }

        .navbar-default .navbar-toggle {
            border-color: transparent;
            color: #ffcb08 !important;
        }

        .panel {
            border: 1px solid #372e30;
            transition: box-shadow 0.5s;
        }

        .panel:hover {
            box-shadow: 5px 0 40px rgba(0, 0, 0, .2);
        }

        .panel-body .btn:hover {
            border: 1px solid #372e30;
            background-color: #fff !important;
            color: #372e30;
        }

        .panel-heading {
            color: #ffcb08 !important;
            background-color: #372e30 !important;
            border-bottom: 1px solid transparent;
        }

        .panel-footer h3 {
            font-size: 32px;
        }

        .panel-footer h4 {
            color: #aaa;
            font-size: 14px;
        }

        .panel-footer .btn {
            margin: 15px 0;
            background-color: #372e30;
            color: #fff;
        }

        #dropdownItem:focus {
            background-color: #372e30;
        }

        label {
            padding-top: 6px;
        }

        .modal {
            padding-top: 60px;
        }

        .modal-header {
            background-color: #372e30;
            color: #ffcb08;
        }
    </style>
</head>
<body style="background-color: #ffcb08;">
<nav class="navbar navbar-default navbar-fixed-top" style="margin: 0;">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/') }}" aria-expanded="false">
                <table>
                    <tbody>
                    <tr>
                        <td>
                            <img src="{{asset('resources/logo-yellow.png')}}" class="img-responsive" alt=""
                                 style="width: 24px; height: 24px; margin-right: 12px;">
                        </td>
                        <td>
                            <div style="color: #ffcb08;">
                                Traffic.uz
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#order" style="color: #ffcb08;">СДЕЛАТЬ ЗАКАЗ</a></li>
                <li><a href="#" style="color: #ffcb08;">ВСЕ ЗАКАЗЫ</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" id="dropdownItem" data-toggle="dropdown" role="button"
                       aria-expanded="false" style="color: #ffcb08;">
                        {{ Auth::user()->name }}<span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu" style="background-color: #372e30;">
                        <li>
                            <a href="{{ route('logout') }}" style="color: #ffcb08;"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                Выйти
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                  style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container" id="order" style="padding: 100px 15px;">
    <form>
        <div class="panel panel-default">
            <div class="panel-heading">
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

                    <div class="form-group col-md-12">
                        <label class="col-md-3">Имя заказчика:</label>
                        <div class="col-md-9">
                            {{Form::text('name', Auth::guard('web')->user()->name,['class'=>'form-control'])}}
                        </div>
                    </div>

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
                        <div class="col-md-2">
                            {{Form::number('discount', $tarifs[0]->discard, ['id' => 'discount_id', 'class' => 'form-control', 'readonly'])}}
                        </div>
                        <div class="col-md-1">
                            <label>%</label>
                        </div>
                        <div class="col-md-1">

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
    </form>

    <div class="modal fade" id="carModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="border-radius: 0;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" style="color: #ffcb08;">&times;</button>
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
                    <button type="button" class="close" data-dismiss="modal" style="color: #ffcb08;">&times;</button>
                    <h4 class="modal-title">Карта</h4>
                </div>
                <div class="modal-body" style="height: 500px; padding: 0; background-color: #372e30;">
                    <div id="firstMap" class="col-md-12" style="height: 500px;"></div>
                </div>
                <div class="modal-footer" style="background-color: #372e30;">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыт</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/app.js') }}"></script>
<script>
    var baseUrl = '{{ URL::asset("") }}';

    function changeCar() {
        showAutoImage();
    }

    function showAutoImage() {
        automobiles = {!! $cars !!};
        document.getElementById('car_image').src = baseUrl + "automobile/" + automobiles[document.getElementById('car_id').selectedIndex]['image'];
    }

    function showAutoInfo() {
        automobiles = {!! $cars !!};
        var info = automobiles[document.getElementById('car_id').selectedIndex]['info'];
        var rows = 0;
        for (var i = 0; i < info.length; i++)
            if (info[i] === '\n')
                rows++;
        document.getElementById('automobile_info').rows = rows + 4;
        document.getElementById('automobile_info').innerHTML = info;
    }

    var firstMap;
    var startPoint = false;
    var endPoint = false;
    var path;

    ymaps.ready(init);

    function init() {
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
</script>
</body>
