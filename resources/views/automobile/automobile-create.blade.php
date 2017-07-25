@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <form class="for-horizontal" method="POST" action="{{ route('automobile.create.submit') }}"
                      enctype="multipart/form-data" id="form">
                    {{ csrf_field() }}
                    <div class="panel panel-default">
                        <div class="panel-heading">Добавить автомобиль</div>
                        <div class="panel-body">
                            <div class="col-md-12 form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-3 control-label">Полное имя:</label>

                                <div class="col-md-9">
                                    <input id="name" type="text" class="form-control" name="name"
                                           value="{{ old('name') }}" required autofocus>
                                    @if ($errors->has('name'))
                                        <span class="help-block">
	                                        <strong>{{ $errors->first('name') }}</strong>
	                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-12 form-group{{ $errors->has('info') ? ' has-error' : '' }}">
                                <label for="info" class="col-md-3 control-label">Информация:</label>
                                <div class="col-md-9">
									<textarea id="info" name="info" rows="10" class="col-md-12" required
                                              style="resize: none;">
									</textarea>
                                    @if ($errors->has('info'))
                                        <span class="help-block">
	                                        <strong>{{ $errors->first('info') }}</strong>
	                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-12 form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                                <label for="price" class="col-md-3 control-label">Цена:</label>
                                <div class="col-md-7">
                                    <input id="price" type="number" min="0" class="form-control" name="price" required>
                                    @if ($errors->has('price'))
                                        <span class="help-block">
	                                        <strong>{{ $errors->first('price') }}</strong>
	                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-2">
                                    <p>сум</p>
                                </div>
                            </div>

                            <div class="col-md-12 form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                                <label for="image" class="col-md-3 control-label">Image</label>
                                <div class="col-md-9">
                                    <input id="price" type="file" min="0" class="form-control" name="image"
                                           accept="image/*">
                                    @if ($errors->has('image'))
                                        <span class="help-block">
	                                        <strong>{{ $errors->first('image') }}</strong>
	                                    </span>
                                    @endif
                                </div>
                            </div>

                        </div>
                        <div class="panel-footer">
                            <input type="submit" class="btn btn-primary" value="Добавить">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection