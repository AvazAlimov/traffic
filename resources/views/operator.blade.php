@extends('layouts.app')
@section('head')
    <style>
        .section {
            display: none;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
                <div class="panel panel-primary">
                    <div class="panel-body">
                        <ul class="nav nav-pills nav-stacked">
                            <li data-toggle="tab" class="active"><a onclick="switchSection('section1')">Тип авто</a>
                            </li>
                            <li data-toggle="tab"><a onclick="switchSection('section2')">Users</a></li>
                            <li data-toggle="tab"><a onclick="switchSection('section3')">Prices</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-10 col-md-offset-0">
                <div id="section1" class="section" style="display: block;">
                    <h1>Automobiles</h1>
                </div>
                <div id="section2" class="section">
                    <h1>Users</h1>
                </div>
                <div id="section3" class="section">
                    <h1>Prices</h1>
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

