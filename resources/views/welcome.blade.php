<!doctype html>
<!--suppress ALL -->
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Traffic.uz</title>
    <link rel="stylesheet" href="{{ asset("css/font-awesome.css") }}">
    <link rel="stylesheet" href="{{ asset("css/bootstrap-datetimepicker.css") }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Shrikhand" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <style>
        @media (max-width: 978px) {
            .panel-body {
                padding: 0;
            }

            #makeorder {
                padding: 10px;
            }

            #pricing {
                padding: 10px;
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

            #orderContiner {
                margin: 0;
                padding: 0;
            }

            .col-centered {
                width: 100%;
            }

            #thirdMap, #mapContainer, #contacts {
                margin: 0;
                padding: 0;
            }
        }

        .navbar-default .navbar-nav > li > a:hover, .navbar-default .navbar-nav > li > a:focus, .navbar-default .navbar-nav > li > a.active {
            background: #372e30;
            color: #fff;
        }

        .navbar-default .navbar-nav > .active > a, .navbar-default .navbar-nav > .active > a:hover, .navbar-default .navbar-nav > .active > a:focus {
            background: #372e30;
            color: #fff;
        }

        body {
            font-family: 'Open Sans', sans-serif;
            line-height: 1.8;
            color: #818181;
        }

        h2 {
            font-size: 24px;
            text-transform: uppercase;
            color: #303030;
            font-weight: 600;
            margin-bottom: 30px;
        }

        h4 {
            font-size: 19px;
            line-height: 1.375em;
            color: #303030;
            font-weight: 400;
            margin-bottom: 30px;
        }

        .container-fluid {
            padding: 60px 50px;
        }

        .bg-yellow {
            background-color: #ffcb08;
        }

        .logo-small {
            color: #372e30;
            font-size: 50px;
        }

        .logo {
            color: #372e30;
            font-size: 200px;
        }

        .thumbnail {
            padding: 0 0 15px 0;
            border: none;
            border-radius: 0;
        }

        .thumbnail img {
            width: 100%;
            height: 100%;
            margin-bottom: 10px;
        }

        .item h4 {
            font-size: 19px;
            line-height: 1.375em;
            font-weight: 400;
            font-style: italic;
            margin: 70px 0;
        }

        h3 {
            color: #372e30;
        }

        .item span {
            font-style: normal;
        }

        .panel {
            border: 1px solid #372e30;
            transition: box-shadow 0.5s;
        }

        .panel:hover {
            box-shadow: 5px 0 40px rgba(0, 0, 0, .2);
        }

        .panel-footer .btn:hover {
            border: 1px solid #372e30;
            background-color: #fff !important;
            color: #372e30;
        }

        .panel-heading {
            color: #ffcb08 !important;
            background-color: #372e30 !important;
            border-bottom: 1px solid transparent;
        }

        .panel-footer {
            background-color: #372e30 !important;
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

        .navbar {
            background-color: #372e30;
            margin-bottom: 0;
            z-index: 9999;
            border: 0;
            font-size: 12px !important;
            line-height: 1.42857143 !important;
            letter-spacing: 4px;
            border-radius: 0;
            font-family: 'Open Sans', sans-serif;
        }

        .navbar-default .navbar-toggle {
            border-color: transparent;
            color: #ffcb08 !important;
        }

        .slideanim {
            visibility: hidden;
        }

        .slide {
            animation-name: slide;
            -webkit-animation-name: slide;
            animation-duration: 1s;
            -webkit-animation-duration: 1s;
            visibility: visible;
        }

        @keyframes slide {
            0% {
                opacity: 0;
                transform: translateY(70%);
            }
            100% {
                opacity: 1;
                transform: translateY(0%);
            }
        }

        @-webkit-keyframes slide {
            0% {
                opacity: 0;
                -webkit-transform: translateY(70%);
            }
            100% {
                opacity: 1;
                -webkit-transform: translateY(0%);
            }
        }

        @media screen and (max-width: 768px) {
            .col-sm-4 {
                text-align: center;
                margin: 25px 0;
            }

            .btn-lg {
                width: 100%;
                margin-bottom: 35px;
            }
        }

        @media screen and (max-width: 480px) {
            .logo {
                font-size: 150px;
            }
        }

        #main_hr {
            width: 200px;
            display: block;
            height: 1px;
            border: 0;
            background-color: #ffcb08;
        }

        hr {
            display: block;
            height: 1px;
            border: 0;
            background-color: #372e30;
        }

        p {
            color: #372e30;
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

        #main_jumbotron {
            background-color: #372e30;
            background-image: url({{asset("/resources/background.png")}});
            background-size: cover;
            background-position: center bottom;
            padding: 100px 25px;
            margin: 0;
        }

        .dotted {
            padding: 2.25em 1.6875em;
            background-image: -webkit-repeating-radial-gradient(center center, rgba(0, 0, 0, .05), rgba(0, 0, 0, .05) 1px, transparent 1px, transparent 100%);
            background-image: -moz-repeating-radial-gradient(center center, rgba(0, 0, 0, .05), rgba(0, 0, 0, .05) 1px, transparent 1px, transparent 100%);
            background-image: -ms-repeating-radial-gradient(center center, rgba(0, 0, 0, .05), rgba(0, 0, 0, .05) 1px, transparent 1px, transparent 100%);
            background-image: repeating-radial-gradient(center center, rgba(0, 0, 0, .05), rgba(0, 0, 0, .05) 1px, transparent 1px, transparent 100%);
            -webkit-background-size: 3px 3px;
            -moz-background-size: 3px 3px;
            background-size: 3px 3px;
        }

        @-webkit-keyframes pulsate {
            0% {
                -webkit-transform: scale(0.9, 0.9);
                opacity: 0.9;
            }
            65% {
                -webkit-transform: scale(1.0, 1.0);
                opacity: 1.0;
            }
            100% {
                -webkit-transform: scale(0.9, 0.9);
                opacity: 0.9;
            }
        }

        .custom_thumbnail {
            padding: 16px;
            border-radius: 8px;
            background-color: #fefefe;
            box-shadow: 0 0 2px #444;
            width: 100%;
        }

        .row-centered {
            text-align: center;
        }

        .col-centered {
            display: inline-block;
            float: none;
            /* reset the text-align */
            text-align: center;
            /* inline-block space fix */
            margin-right: -4px;
        }

        #makeorder {
            background-image: url("{{ asset('/resources/map.svg') }}");
            background-size: cover;
        }
    </style>
</head>

<body id="app" data-spy="scroll" data-target=".navbar" data-offset="60">

<nav class="navbar navbar-default navbar-fixed-top" style="margin: 0;">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#" aria-expanded="false">
                <table>
                    <tbody>
                    <tr>
                        <td>
                            <img src="{{asset('resources/logo-yellow.png')}}" class="img-responsive" alt=""
                                 style="width: 24px; height: 24px; margin-right: 12px;">
                        </td>
                        <td>
                            <div style="color: #ffcb08; font-family: 'Shrikhand', cursive;">
                                T r a f f i c . u z
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#makeorder" style="color: #ffcb08;">СДЕЛАТЬ ЗАКАЗ</a></li>
                <li><a href="#about" class="active" style="color: #ffcb08;">О НАС</a></li>
                <li><a href="#pricing" style="color: #ffcb08;">ТАРИФЫ</a></li>
                <li><a href="#contacts" style="color: #ffcb08;">КОНТАКТЫ</a></li>
                @if(Illuminate\Support\Facades\Auth::check())
                    <li><a href="{{ url('/home') }}" style="color: #ffcb08;"><i class="fa fa-home"
                                                                                aria-hidden="true"></i> ГЛАВНАЯ</a></li>
                @else
                    <li><a href="{{ url('/login') }}" style="color: #ffcb08;"><i class="fa fa-sign-in"
                                                                                 aria-hidden="true"></i> ВОЙТИ</a></li>
                    <li><a href="{{ url('/register') }}" style="color: #ffcb08;"><i class="fa fa-unlock-alt"
                                                                                    aria-hidden="true"></i>
                            РЕГИСТРАЦИЯ</a></li>
                @endif
            </ul>
        </div>
    </div>
</nav>

<div id="main_jumbotron" class="jumbotron text-center">
    <img src="{{asset('resources/logo-yellow.png')}}" style="width: 128px; height: 128px;">
    <h1 style="color: #ffcb08; font-family: 'Shrikhand', cursive;">TRAFFIC.UZ</h1>
    <hr id="main_hr">
    <h2 style="color: #ffcb08;">Быстро и удобно!</h2>
    <a href="#makeorder" class="btn"
       style="color: #372e30; background-color: #ffcb08; font-size: 24px; -webkit-animation: pulsate 2.4s ease-out;
    -webkit-animation-iteration-count: infinite; ">СДЕЛАТЬ
        ЗАКАЗ</a>
</div>

<div class="container-fluid bg-yellow" id="makeorder">
    <div class="container slideanim">
        <div class="panel panel-default">
            <div class="panel-heading" style="background-color: #372e30;">
                <h4 style="color: #ffcb08; margin-bottom: 0;">
                    СДЕЛАТЬ ЗАКАЗ НА
                </h4>
                <div class="btn-group" data-toggle="buttons">
                    <button class="btn btn-warning active" data-toggle="tab"
                            data-target="#trucking" style="color: #372e30;" id="trucking_tab">
                        ГРУЗОПЕРЕВОЗКУ
                    </button>
                    <button class="btn btn-warning" data-toggle="tab"
                            data-target="#taxi" style="color: #372e30;" id="taxi_tab">
                        ТАКСИ
                    </button>
                </div>
            </div>
            <div class="panel-body tab-content">
                <div class="tab-pane active" id="trucking">
                    <form action="{{ route('web.order.submit') }}" method="post">
                        {{ csrf_field() }}
                        <div class="col-md-6">
                            <div class="form-group col-md-12">
                                <label for="trucking_tariff_id" class="col-md-4">
                                    Тариф:
                                </label>
                                <div class="col-md-8">
                                    <select name="tariff_id" id="trucking_tariff_id"
                                            class="form-control" onchange="changeTariff()">
                                        @foreach($tariff as $index => $item)
                                            <option value="{{ $index }}">{{ $item }}</option>
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
                                           class="form-control">
                                </div>
                            </div>

                            <div class="form-group col-md-12 {{ $errors->has('phone') ? ' has-error' : '' }}">
                                <label for="trucking_phone" class="col-md-5">
                                    Телефон заказчика:
                                </label>
                                <div class="col-md-7">
                                    <input type="text" name="phone" id="trucking_phone"
                                           class="form-control"
                                           value="+998">
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
                                <button type="button" class="btn btn-block" onclick="refreshTrucking()"
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
                    <form action="{{ route('web.taxiorder.submit') }}" method="post">
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
                                           class="form-control">
                                </div>
                            </div>

                            <div class="form-group col-md-12 {{ $errors->has('phone') ? ' has-error' : '' }}">
                                <label for="taxi_phone" class="col-md-5">
                                    Телефон заказчика:
                                </label>
                                <div class="col-md-7">
                                    <input type="text" name="phone" id="taxi_phone"
                                           class="form-control"
                                           value="+998">
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
                                <button type="button" class="btn btn-block" onclick="refreshTaxi()"
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

    <div class="modal fade" id="mainModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="border: none;">
                <div class="modal-header" style="border: none;">
                    <button type="button" class="close" data-dismiss="modal" style="color: #ffcb08;">&times;</button>
                    <h4 class="modal-title" style="color: #ffcb08;">УКАЖИТЕ АДРЕС</h4>
                </div>
                <div class="modal-body" style="height: 500px; padding: 0; background-color: #372e30;">
                    <div id="navigationMap" class="col-md-12" style="height: 500px;"></div>
                </div>
                <div class="modal-footer" style="background-color: #372e30; border: none;">
                    <button type="button" class="btn btn-default" data-dismiss="modal"
                            style="background-color: #ffcb08; color: #372e30; border: none;">
                        Сохранить
                    </button>
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
                    <p class="modal-title" style="color: #ffcb08;">Автомобиль</p>
                </div>
                <div class="modal-body">
                    <textarea id="automobile_info" style="width: 100%; resize: none; border-width: 0;"
                              readonly></textarea>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="about" class="container-fluid dotted">
    <div class="container slideanim">
        <h2 class="text-center">О НАС</h2>

        <div class="col-md-4">
            <h3><strong>КТО</strong> МЫ</h3>
            <hr>
            <p>
                Компания SOS (Smart Outsourcing Solutions) занимается разработкой сайтов, мобильных приложений,
                продвижением сайтов и дизайном рекламы. Компания сотрудничает со многими успешными отечественными
                компаниями и предприятиями. Также налажено многогранное и успешное сотрудничество со многими зарубежными
                компаниями из Австралии, США, ОАЭ и т.д.
            </p>
        </div>

        <div class="col-md-4">
            <h3><strong>ЧТО</strong> ДЕЛАЕМ</h3>
            <hr>
            <p>
                Команда профессиональных, отважных и креативных специалистов, которая готова реализовать любые ваши
                пожелания от разработки уникальных и неповторимых сайтов до создания бренда с дизайном упаковки,
                логотипа и фирменного стиля, для повышения эффективности вашего бизнеса и значительного повышения ваших
                продаж
            </p>
        </div>

        <div class="col-md-4">
            <h3><strong>НАША</strong> МИССИЯ</h3>
            <hr>
            <p>
                Наша главная миссия: Стремительно развиваться в сфере интернет-технологий и занять лидирующие позиции на
                рынке Узбекистана, параллельно добиваясь мирового успеха посредством сотрудничества с развитыми
                международными компаниями!
            </p>
        </div>

        <hr class="col-md-12">
    </div>
    <div class="container text-center">
        <h2>8 причин заказывать грузоперевозки в «Траффик»</h2>
        <br>
        <div class="row slideanim">
            <div class="col-sm-3">
                <span class="glyphicon glyphicon-thumbs-up logo-small"></span>
                <h4>Низкие цены</h4>
            </div>
            <div class="col-sm-3">
                <span class="glyphicon glyphicon-dashboard logo-small"></span>
                <h4>Срочная подача машины через 15 минут!</h4>
            </div>
            <div class="col-sm-3">
                <span class="glyphicon glyphicon-calendar logo-small"></span>
                <h4>Работаем 24 часа без выходных</h4>
            </div>
            <div class="col-sm-3">
                <span class="fa fa-handshake-o logo-small"></span>
                <h4>100% материальная ответственность</h4>
            </div>
        </div>
        <br>
        <div class="row slideanim">
            <div class="col-sm-3">
                <span class="fa fa-truck logo-small"></span>
                <h4>Широкий выбор автомобилей!</h4>
            </div>
            <div class="col-sm-3">
                <span class="fa fa-credit-card logo-small"></span>
                <h4>Удобные способы оплаты</h4>
            </div>
            <div class="col-sm-3">
                <span class="fa fa-address-card-o logo-small"></span>
                <h4 style="color:#303030;">Опытные водители и аккуратные грузчики</h4>
            </div>
            <div class="col-sm-3">
                <span class="glyphicon glyphicon-ok-circle logo-small"></span>
                <h4>Высокий уровень сервиса грузоперевозок</h4>
            </div>
        </div>
        <br>

        <hr class="col-md-12">
    </div>
    <div class="container text-center">
        <h2>Автопарк</h2>
        <br>
        <div class="col-md-12">
            @foreach($automobiles as $car)
                @if(($loop->index % 4) == 0)
                    <div class="row slideanim row-centered">
                        @endif
                        <div class="col-md-3 col-centered">
                            <div class="custom_thumbnail">
                                <img src="{{ asset("/automobile/".$car->image) }}" alt="{{ $car->name }}"
                                     style="height: 70px;">
                                <div class="caption">
                                    <p style="font-size: 16px; margin-top: 6px;">
                                        <strong>{{ $car->name }}</strong>
                                    </p>
                                    <p>
                                        <strong>Цена: </strong>
                                        {{ $car->price }} сум
                                    </p>
                                    <button class="btn" data-toggle="modal" data-target="#carModal"
                                            style="background-color: #372e30; color: #ffcb08;"
                                            onclick="showThumbAutoInfo({{ $loop->index }})">
                                        Инфо
                                    </button>
                                </div>
                            </div>
                            <br>
                        </div>
                        @if(($loop->index % 4) == 3 && !$loop->last)
                    </div>
                @endif
                @if($loop->last)
        </div>
        @endif
        @endforeach
    </div>
</div>
</div>

<div id="pricing" class="container-fluid text-center bg-yellow">
    <div class="container">

        <div class="text-center">
            <h2>ТАРИФЫ</h2>
        </div>
        <div class="row slideanim">
            @foreach($tariffs as $item)
                <div class="col-sm-6 col-xs-12">
                    <div class="panel panel-default text-center">
                        <div class="panel-heading">
                            <h3 style="color: #ffcb08;"> {{ $item->type == 0 ? "Внутри города" : "За городом" }}</h3>
                        </div>
                        <div class="panel-body">
                            <h4>
                                <strong>{{ $item->type == 0 ? "Цена за час:" : "Цена за км:" }}</strong> {{ $item->type == 0 ? $item->price_per_hour : $item->price_per_distance }}
                                сум</h4>
                            <h4>
                                <strong>{{ $item->type == 0 ? "По умолчанию (час):" : "По умолчанию (км):" }}</strong> {{ $item->type == 0 ? $item->min_hour : $item->min_distance }}
                            </h4>
                            <h4><strong>Начальная цена:</strong> {{ $item->price_minimum  }} сум</h4>
                            <h4><strong>Плата за обслуживание
                                    погрузчика:</strong> {{ $item->price_per_person  }} сум
                            </h4>
                            <h4><strong>Скидка:</strong> {{ $item->discard  }} %</h4>
                        </div>
                        <div class="panel-footer">
                            <a href="#makeorder" class="btn"
                               style="color: #ffcb08; font-size: 24px;">Заказать</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div id="contacts" class="container-fluid text-center dotted">
    <div class="col-md-6">
        <div class="row slideanim">
            <h2>Телефоны колл-центра</h2>
            <img src="{{asset('resources/call.png')}}" alt="" style="width: 96px; height: 96px;">
            <h2>+998 (71) 147-73-73</h2>
            <h2>+998 (90) 373-73-73</h2>
            <h4>Звоните в любое время и когда угодно!</h4>
            <h2>НАШ АДРЕС</h2>
            <h4>
                Лалит Угон 1, Шайхантахур, Ташкент
                Tashkent, Uzbekistan
            </h4>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row slideanim" id="mapContainer">
            <div id="thirdMap" class="col-md-12" style="height: 470px;"></div>
        </div>
    </div>
    <br>
    <br>
</div>

<footer class="container-fluid text-center" style="background-color: #372e30;">
    <a href="#" data-scroll-goto="0" data-section="top">
        <button class="btn"
                style="margin-top: -150px; background-color: #372e30; width: 64px; height: 64px; border-radius: 32px; box-shadow: 0 2px 4px #ffcb08;">
            <i class="fa fa-angle-up" style="font-size: 24px; color: #ffcb08;"></i>
        </button>
    </a>

    <div class="container">
        <div class="row slideanim">
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

<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset("js/bootstrap-datetimepicker.js") }}"></script>
<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
<script>
    $(document).ready(function () {
        // Add smooth scrolling to all links in navbar + footer link
        $(".navbar a, footer a[href='#myPage']").on('click', function (event) {
            // Make sure this.hash has a value before overriding default behavior
            if (this.hash !== "") {
                // Prevent default anchor click behavior
                event.preventDefault();

                // Store hash
                var hash = this.hash;

                // Using jQuery's animate() method to add smooth page scroll
                // The optional number (900) specifies the number of milliseconds it takes to scroll to the specified area
                $('html, body').animate({
                    scrollTop: $(hash).offset().top
                }, 900, function () {

                    // Add hash (#) to URL when done scrolling (default click behavior)
                    window.location.hash = hash;
                });
            } // End if
        });

        $(window).scroll(function () {
            $(".slideanim").each(function () {
                var pos = $(this).offset().top;

                var winTop = $(window).scrollTop();
                if (pos < winTop + 600) {
                    $(this).addClass("slide");
                }
            });
        });
    });

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

    function showThumbAutoInfo(value) {
        var info = arrays[1][value]['info'];
        var rows = 0;
        for (var i = 0; i < info.length; i++)
            if (info[i] === '\n')
                rows++;
        document.getElementById('automobile_info').rows = rows + 4;
        document.getElementById('automobile_info').innerHTML = info;
    }

    //----- Maps Scripts Start -----//
    var navigationMap;
    var startPoint = false;
    var endPoint = false;
    var distance = 0;
    var path;

    function initMaps() {
        var address = new ymaps.Map("thirdMap", {
            center: [41.323100, 69.230100],
            zoom: 14,
            controls: []
        });
        address.geoObjects.add(new ymaps.Placemark([41.323100, 69.230100], {
            balloonContent: 'Наш Офис'
        }, {
            preset: 'islands#redHomeIcon',
            iconColor: '#F44336'
        }));

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

    function refreshTrucking() {
        document.getElementById("trucking_tariff_id").selectedIndex =
                document.getElementById("trucking_automobile_id").selectedIndex =
                        document.getElementById("trucking_loaders").value =
                                document.getElementById("trucking_distance").value = 0;
        document.getElementById("trucking_hour").value =
                (arrays[0][0]['type'] === 0) ? arrays[0][0]['min_hour'] : arrays[0][1]['min_hour'];
        document.getElementById("trucking_address_a").value =
                document.getElementById("trucking_address_b").value =
                        document.getElementById("trucking_point_a").value =
                                document.getElementById("trucking_point_b").value = "";
        startPoint = endPoint = false;
        navigationMap.geoObjects.removeAll();
        changeTariff();
        changeAutomobile();
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

    function refreshTaxi() {
        document.getElementById("taxi_minute").value = taxiTariff[0]['min_minute'];
        document.getElementById("taxi_distance").value = 0;
        document.getElementById("taxi_address_a").value =
                document.getElementById("taxi_address_b").value =
                        document.getElementById("taxi_point_a").value =
                                document.getElementById("taxi_point_b").value = "";
        startPoint = endPoint = false;
        navigationMap.geoObjects.removeAll();
        calculateTaxiPrice();
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
</body>
</html>