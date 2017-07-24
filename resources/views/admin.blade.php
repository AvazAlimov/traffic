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
                    @php
                        $a = 0;
                    @endphp
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th class="col-md-2">Name</th>
                                <th class="col-md-5">Info</th>
                                <th class="col-md-1">Price</th>
                                <th>Image</th>
                                <th class="col-md-2">Controls</th>
                            </tr>
                            </thead>
                            @foreach ($automobiles as $automobile)
                                <tbody>
                                <tr>
                                    <td>{{ $a + 1 }}</td>
                                    <td>{{ $automobile->name }}</td>
                                    <td>{{ $automobile->info }}</td>
                                    <td>{{ $automobile->price }}</td>
                                    <td><img id="price" src="{{ "automobile/".$automobile->image }}"
                                             style="width: 200px; height: 120px;"></td>
                                    <td>
                                        <form action="{{ route('automobile.show', $automobile->id) }}" method="get">
                                            <button type="submit" class="btn btn-default">Edit</button>
                                        </form>
                                        <form action="{{ route('automobile.delete', $automobile->id) }}" method="post">
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-default">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                                {{ $a++ }}
                                @endforeach
                                </tbody>
                        </table>
                    </div>
                    <form action="{{ route('automobile.create') }}" method="GET">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-primary">
                            Add
                        </button>
                    </form>
                </div>
                <div id="section2" class="section">
                    <h1>Users</h1>
                    @php
                        $a = 0;
                    @endphp
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th class="col-md-3">Name</th>
                                <th class="col-md-3">Image</th>
                                <th class="col-md-2">Created At</th>
                                <th class="col-md-2"></th>
                            </tr>
                            </thead>
                            @foreach ($operators as $operator)
                                <tbody>
                                <tr>
                                    <td>{{ $a + 1 }}</td>
                                    <td>{{ $operator->name }}</td>
                                    <td>{{ $operator->image }}</td>
                                    <td>{{ $operator->created_at }}</td>
                                    <th>
                                        <form action="{{ route('operator.show', $operator->id) }}" method="get">
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-default">Edit</button>
                                        </form>
                                        <form action="{{ route('operator.delete', $operator->id) }}" method="post">
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-default">Remove</button>
                                        </form>
                                    </th>
                                </tr>
                                {{ $a++ }}
                                @endforeach
                                </tbody>
                        </table>
                    </div>
                    <form action="{{ route('operator.create') }}" method="GET">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-primary">
                            Add
                        </button>
                    </form>
                </div>
                <div id="section3" class="section">
                    <h1>Prices</h1>
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
                                                            <label for="discard" class="col-md-4 control-label">Discard</label>
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
                                                            <label for="price_per_distance" class="col-md-4 control-label">Price
                                                                per distance</label>
                                                            <div class="col-md-8">
                                                                <input id="price_per_distance" type="number" min="0"
                                                                       class="form-control"
                                                                       name="price_per_distance"
                                                                       value="{{ $tarif->price_per_distance }}" required>
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
                                                            <label for="discard" class="col-md-4 control-label">Discard</label>
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
