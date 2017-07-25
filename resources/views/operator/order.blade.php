@extends('layouts.app')
@section('head')
@endsection
@section('content')

    <div class="container-fluid">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Order</div>
                <div class="panel-body">

                    {{Form::open(['route' => ['operator.order.submit'], 'method' => 'post'])}}

                    <div class="form-group col-md-12">
                        <label class="col-md-2"> Tarif</label>
                        <div class="col-md-10">
                            {{Form::select('tarifs[]', $tarif,null,['placeholder' => 'Select tarifs ...', 'class'=>'form-control', 'onchange'=>'changeTarif()', 'id'=>'tarif_id'])}}
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label class="col-md-2"> Car</label>
                        <div class="col-md-10">
                            {{Form::select('cars[]', $car, null, ['placeholder' => 'Select automobile ...', 'class'=>'form-control'])}}
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label class="col-md-2"> Persons</label>
                        <div class="col-md-10">
                            {{Form::number('persons', null, ['max' => 8, 'min'=>0 ,  'class'=>'form-control', 'id' =>'person_id'])}}
                        </div>
                    </div>

                    <div class="form-group col-md-12">
                        <label class="col-md-2"> Start Time</label>
                        <div class="col-md-7">
                            {{Form::date('date', \Carbon\Carbon::now(), ['class'=>'form-control'])}}
                        </div>
                        <div class="col-md-3">
                            {{Form::time('time', \Carbon\Carbon::now()->setTimezone('Asia/Tashkent')->format('h:i'), ['class'=>'form-control'])}}
                        </div>
                    </div>


                    <div class="form-group col-md-12">
                        <label id="label_tarif" class="col-md-2">Unit</label>
                        <div class="col-md-10">
                            {{Form::number('unit',null, ['class'=>'form-control'])}}
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label class="col-md-2"> From </label>
                        <div class="col-md-4">
                            {{Form::text('address_A',null, ['class'=>'form-control', 'id'=>'address_a'])}}
                        </div>
                        <label class="col-md-1"> To </label>
                        <div class="col-md-4">
                            {{Form::text('address_B',null, ['class'=>'form-control', 'id'=>'address_b'])}}
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-default"><i class="fa fa-compass"></i></button>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label class="col-md-2"> From </label>
                        <div class="col-md-4">
                            {{Form::text('point_A',null, ['id'=>'point_a', 'class'=>'form-control'])}}
                        </div>
                        <label class="col-md-1"> To </label>
                        <div class="col-md-4">
                            {{Form::text('point_B',null,['id'=>'point_b', 'class'=>'form-control'])}}
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-default"><i class="fa fa-compass"></i></button>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label class="col-md-2">Price</label>
                        <div class="col-md-10">
                            {{Form::number('price',null, ['class'=>'form-control', 'id'=>'sum_id'])}}
                        </div>
                    </div>
                    {{Form::close()}}
                </div>
            </div>
            {{$tarifs[0]}}
        </div>
    </div>
    </div>

    <script>
        var minimum_price;
        var array = {!! $tarifs !!}
        alert(array[0]['price_minimum']);
        function changeTarif() {
            var index = document.getElementById('tarif_id').value;

            if (index === 0) {
                document.getElementById('label_tarif').innerHTML = "Hour ";

            }
            else {
                document.getElementById('label_tarif').innerHTML = "Kilometre ";

            }

            calculatePrice();
        }
        function calculatePrice() {
            var sum = minimum_price;
            document.getElementById('sum_id').value =sum;
        }
    </script>
@endsection