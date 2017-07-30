<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Traffic.uz</title>
    <link rel="stylesheet" href="{{asset('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css')}}" type="text/css">
    <link href="{{asset('https://fonts.googleapis.com/css?family=Raleway:100,600')}}" rel="stylesheet" type="text/css">

    <script src="{{asset('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js')}}"></script>
    <script src="{{asset('https://api-maps.yandex.ru/2.1/?lang=ru_RU')}}" type="text/javascript"></script>
    @yield('styles')
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
                <li><a href="{{route('user.orders')}}" style="color: #ffcb08;">ВСЕ ЗАКАЗЫ</a></li>
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
@yield('content')


<script src="{{ asset('js/app.js') }}"></script>

@yield('scripts')
</body>
