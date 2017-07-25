@extends('layouts.app')
@section('head')



@endsection
@section('content')
    <div class="panel-content">
    {{Form::open(['route' => ['operator.order.submit'], 'method' => 'post', 'class'=>'form-group'])}}

        <div class="">
            <label> Car</label>
        {{Form::select('cars[]', $cars, null, ['placeholder' => 'Select automobile ...'])}}
        </div>
        <div>
            <label> Tarif</label>
            {{Form::select('tarifs[]', $tarifs,null,['placeholder' => 'Select tarifs ...'])}}
        </div>
        <div>
            <label> Persons</label>
            {{Form::number('persons', null, ['max' => 8])}}
        </div>
        <div>
            <label> Start Time</label>
            {{Form::date('date', \Carbon\Carbon::now())}}
            {{Form::time('time', \Carbon\Carbon::now()->setTimezone('Asia/Tashkent')->format('h:i'))}}
        </div>
        <div>
            <label> Unit km/hour</label>
            {{Form::number('unit')}}
        </div>
        <div>
            <label> From </label>
            {{Form::text('address_A',null)}}
            {{Form::text()}}
        </div>
        <div>
            <label> To </label>
            {{Form::text('address_B',null)}}
        </div>


        {{Form::close()}}

    </div>


@endsection