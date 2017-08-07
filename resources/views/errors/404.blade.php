<!DOCTYPE html>
<!--suppress ALL -->
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Traffic.uz</title>
    <style>
        html {
            height: 100%;
            overflow-y: hidden;
            overflow-x: hidden;
        }

        body {
            height: 100%;
            width: 100%;
            display: table;
            background: url("{{asset('resources/background.png')}}") no-repeat center bottom;
            -webkit-background-size: cover;
            background-size: cover;
            background-color: #372e30;
        }

        h1, h2, a {
            color: #ffcb08;
        }

        center {
            display: table-cell;
            height: 100%;
            vertical-align: middle;
        }
    </style>
</head>
<body>
<center>
    <img src="{{asset('resources/logo-yellow.png')}}" alt="Traffic.uz" style="width: 128px;">
    <h1>Ошибка 404<br>Страница не найдена!</h1>
    <br>
    <h2><a href="{{url("/")}}">Перейти на главную страницу</a></h2>
</center>
</body>
</html>