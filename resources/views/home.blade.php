<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <style>
        .footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            background-color: #372e30;
            padding: 25px;
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

        #dropdownItem:focus{
            background-color: #372e30;
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
<div class="container" style="padding: 100px 15px;">

</div>
<footer class="text-center footer">
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
        <div class="col-md-12 col-sm-12">
            <h4 style="color: #ffcb08;">Ташкент 2017</h4>
        </div>
    </div>
</footer>
<script src="{{ asset('js/app.js') }}"></script>
</body>
