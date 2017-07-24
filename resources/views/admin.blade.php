@extends('layouts.app')
@section('head')
    <style>
        .section{
            display: none;
        }
    </style>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">
            <div class="panel panel-primary">
                {{-- <div class="panel-heading">Admin Dashboard</div> --}}
                <div class="panel-body">
                    <ul class="nav nav-pills nav-stacked">
                        <li data-toggle="tab" class="active"><a onclick="switchSection('section1')">Тип авто</a></li>
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
                            <td><img id="price" src="{{ "automobile/".$automobile->image }}" style="width: 200px; height: 120px;"></td>
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
                            <th class="col-md-3">Email</th>
                            <th class="col-md-2">Created At</th>
                            <th class="col-md-2"></th>
                          </tr>
                        </thead>
                        @foreach ($operators as $operator)
                        <tbody>
                          <tr>
                            <td>{{ $a + 1 }}</td>
                            <td>{{ $operator->name }}</td>
                            <td>{{ $operator->email }}</td>
                            <td>{{ $operator->created_at }}</td>
                            <th>
                                <form action="{{ route('operator.show', $operator->id) }}" method="get">
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
            </div>
        </div>
    </div>
</div>

<script>
    function switchSection(id)
    {
        var section = document.getElementsByClassName('section');
        for(var i = 0; i < section.length; i++)
            section[i].style.display = "none";
        document.getElementById(id).style.display = "block";
    }
</script>
@endsection
