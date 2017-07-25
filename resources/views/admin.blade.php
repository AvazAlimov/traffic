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
            <li data-toggle="tab" class="active"><a onclick="switchSection('section1')"><i class="fa fa-car"></i>
                    Автомобили</a></li>
            <li data-toggle="tab"><a onclick="switchSection('section2')"><i class="fa fa-users"></i> Операторы</a>
            </li>
            <li data-toggle="tab"><a onclick="switchSection('section3')"><i class="fa fa-money"></i> Цены</a></li>
        </ul>
    </nav>
    <div class="container" style="padding: 0 20px 20px 20px">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div id="section1" class="section" style="display: block;">
                    <div class="page-header">
                        <h2>Автомобили</h2>
                    </div>
                    @foreach ($automobiles as $automobile)
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <strong>{{ $automobile->name }}</strong>
                            </div>
                            <div class="panel-body">
                                <div class="media">
                                    <div class="media-left">
                                        <img id="price" src="{{ "automobile/".$automobile->image }}">
                                    </div>
                                    <div class="media-body">
                                        <h3 class="media-heading">{{ $automobile->price }} сум</h3>
                                        <p>{{ $automobile->info }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <table>
                                    <tbody>
                                    <tr>
                                        <td>
                                            <form action="{{ route('automobile.show', $automobile->id) }}"
                                                  method="get">
                                                <button type="submit" class="btn btn-primary pull-right">Изменить
                                                </button>
                                            </form>
                                        </td>
                                        <td>
                                            <form action="{{ route('automobile.delete', $automobile->id) }}"
                                                  method="post">
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger pull-right">Удалить</button>
                                            </form>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                    <form action="{{ route('automobile.create') }}" method="GET">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-primary pull-right">
                            Добавить автомобиль
                        </button>
                    </form>
                </div>
                <div id="section2" class="section">
                    <div class="page-header">
                        <h2>Операторы</h2>
                    </div>
                    @foreach ($operators as $operator)
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <strong>{{ $operator->username }}</strong>
                            </div>
                            <div class="panel-body">
                                <div class="media">
                                    <div class="media-left">
                                        <img src="{{ "operator/".$operator->image }}" class="img-circle" style="width: 128px; height: 128px">
                                    </div>
                                    <div class="media-body">
                                        <h3 class="media-heading">Имя: {{ $operator->name }}</h3>
                                        <br>
                                        <p><strong>Создан:</strong> {{ $operator->created_at }}</p>
                                        <p><strong>Обновлен:</strong> {{ $operator->updated_at }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <table>
                                    <tbody>
                                    <tr>
                                        <td>
                                            <form action="{{ route('operator.show', $operator->id) }}" method="get">
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-primary pull-right">Изменить</button>
                                            </form>
                                        </td>
                                        <td>
                                            <form action="{{ route('operator.delete', $operator->id) }}" method="post">
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger pull-right">Удалить</button>
                                            </form>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach

                    <form action="{{ route('operator.create') }}" method="GET">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-primary pull-right">
                            Добавить оператор
                        </button>
                    </form>
                </div>
                <div id="section3" class="section">
                    <h1>Цены</h1>
                    @foreach ($tarifs as $tarif)
                        @if($tarif->type == 0)
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <strong>Inside City</strong>
                                            </div>
                                            <div class="panel-body">
                                                <form class="for-horizontal"
                                                      action="{{ route('tarif.update', $tarif->id)  }}" method="post">
                                                    {{ csrf_field() }}
                                                    <div class="form-group">
                                                        <div class="col-md-12">
                                                            <label for="price_per_hour" class="col-md-4 control-label">Price
                                                                per hour</label>
                                                            <div class="col-md-8">
                                                                <input id="price_per_hour" type="number" min="0"
                                                                       class="form-control"
                                                                       name="price_per_hour"
                                                                       value="{{ $tarif->price_per_hour }}" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-md-12">
                                                            <label for="min_hour" class="col-md-4 control-label">Minimum
                                                                hour</label>
                                                            <div class="col-md-8">
                                                                <input id="min_hour" type="number" min="0"
                                                                       class="form-control"
                                                                       name="min_hour"
                                                                       value="{{ $tarif->min_hour }}" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-md-12">
                                                            <label for="price_minimum" class="col-md-4 control-label">Starting
                                                                price</label>
                                                            <div class="col-md-8">
                                                                <input id="price_minimum" type="number" min="0"
                                                                       class="form-control"
                                                                       name="price_minimum"
                                                                       value="{{ $tarif->price_minimum }}" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-md-12">
                                                            <label for="price_per_person"
                                                                   class="col-md-4 control-label">Price for
                                                                person</label>
                                                            <div class="col-md-8">
                                                                <input id="price_per_person" type="number" min="0"
                                                                       class="form-control"
                                                                       name="price_per_person"
                                                                       value="{{ $tarif->price_per_person }}" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-md-12">
                                                            <label for="discard"
                                                                   class="col-md-4 control-label">Discard</label>
                                                            <div class="col-md-8">
                                                                <input id="discard" type="number" min="0"
                                                                       class="form-control"
                                                                       name="discard"
                                                                       value="{{ $tarif->discard }}" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-md-12">
                                                            <input type="submit" class="btn btn-primary">
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <strong>Outside City</strong>
                                            </div>
                                            <div class="panel-body">
                                                <form class="for-horizontal"
                                                      action="{{ route('tarif.update', $tarif->id)  }}" method="post">
                                                    {{ csrf_field() }}
                                                    <div class="form-group">
                                                        <div class="col-md-12">
                                                            <label for="price_per_distance"
                                                                   class="col-md-4 control-label">Price
                                                                per distance</label>
                                                            <div class="col-md-8">
                                                                <input id="price_per_distance" type="number" min="0"
                                                                       class="form-control"
                                                                       name="price_per_distance"
                                                                       value="{{ $tarif->price_per_distance }}"
                                                                       required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-md-12">
                                                            <label for="min_distance" class="col-md-4 control-label">Minimum
                                                                distance</label>
                                                            <div class="col-md-8">
                                                                <input id="min_distance" type="number" min="0"
                                                                       class="form-control"
                                                                       name="min_distance"
                                                                       value="{{ $tarif->min_distance }}" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-md-12">
                                                            <label for="price_minimum" class="col-md-4 control-label">Starting
                                                                price</label>
                                                            <div class="col-md-8">
                                                                <input id="price_minimum" type="number" min="0"
                                                                       class="form-control"
                                                                       name="price_minimum"
                                                                       value="{{ $tarif->price_minimum }}" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-md-12">
                                                            <label for="price_per_person"
                                                                   class="col-md-4 control-label">Price for
                                                                person</label>
                                                            <div class="col-md-8">
                                                                <input id="price_per_person" type="number" min="0"
                                                                       class="form-control"
                                                                       name="price_per_person"
                                                                       value="{{ $tarif->price_per_person }}" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-md-12">
                                                            <label for="discard"
                                                                   class="col-md-4 control-label">Discard</label>
                                                            <div class="col-md-8">
                                                                <input id="discard" type="number" min="0"
                                                                       class="form-control"
                                                                       name="discard"
                                                                       value="{{ $tarif->discard }}" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-md-12">
                                                            <input type="submit" class="btn btn-primary">
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                    {{--<td>{{ $tarif->type}}</td>--}}
                    {{--<td>{{ $tarif->price_per_distance }}</td>--}}
                    {{--<td>{{ $tarif->min_distance }} km</td>--}}
                    {{--<td>{{ $tarif->price_minimum }}</td>--}}
                    {{--<td>{{ $tarif->price_per_person }}</td>--}}
                    {{--<td>{{ $tarif->discard }}</td>--}}
                    {{--<td>{{ $tarif->updated_at }}</td>--}}
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
