@extends('layouts.app')
@section('head')
    <style>
        .section {
            display: none;
        }

        #navbar {
            margin: 0;
        }
    </style>
@endsection
@section('content')
    <nav class="navbar navbar-default" style="border-radius: 0; border-width: 0 0 thin 0;">
        <ul class="nav navbar-nav">
            <li data-toggle="tab" class="active"><a onclick="switchSection('section1')"><i class="fa fa-list-alt"></i>
                    Заказы</a></li>
            <li data-toggle="tab"><a onclick="switchSection('section2')"><i class="fa fa-columns"></i> Сделать заказ</a>
            </li>
        </ul>
    </nav>
    <div class="container" style="padding: 0 20px 20px 20px">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div id="section1" class="section" style="display: block;">
                    <div class="page-header">
                        <h2>Заказы</h2>
                    </div>
                </div>
                <div id="section2" class="section">
                    <div class="page-header">
                        <h2>Сделать заказ</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function switchSection(id) {
            var section = document.getElementsByClassName('section');
            for (var i = 0; i < section.length; i++)
                section[i].style.display = "none";
            document.getElementById(id).style.display = "block";
        }
    </script>
@endsection
