@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Update Automobile</div>
                    <div class="panel-body">
                        <form class="for-horizontal" method="POST" enctype="multipart/form-data"
                              action="{{ route('automobile.update', $automobile->id) }}">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-2 control-label">Name</label>

                                <div class="col-md-10">
                                    <input id="name" type="text" class="form-control" name="name"
                                           value="{{ $automobile->name }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
	                                        <strong>{{ $errors->first('name') }}</strong>
	                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('info') ? ' has-error' : '' }}">
                                <label for="info" class="col-md-2 control-label">Info</label>

                                <div class="col-md-10">
                                    <textarea id="info" name="info" rows="8" class="col-md-12" required
                                              style="resize: none;">{{ $automobile->info }}</textarea>
                                    @if ($errors->has('info'))
                                        <span class="help-block">
	                                        <strong>{{ $errors->first('info') }}</strong>
	                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                                <label for="price" class="col-md-2 control-label">Price</label>

                                <div class="col-md-10">
                                    <input id="price" type="number" min="0" class="form-control" name="price" required
                                           value="{{ $automobile->price }}">

                                    @if ($errors->has('price'))
                                        <span class="help-block">
	                                        <strong>{{ $errors->first('price') }}</strong>
	                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="old_image" class="col-md-2 control-label">Image</label>

                                <div class="col-md-10">
                                    <img id="price" src="{{ $automobile->image }}" style="width: 300px; height: 200px;">
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                                <label for="image" class="col-md-2 control-label">New Image</label>

                                <div class="col-md-10">
                                    <input id="price" type="file" class="form-control" name="image"
                                           value="{{ $automobile->image }}">

                                    @if ($errors->has('image'))
                                        <span class="help-block">
	                                        <strong>{{ $errors->first('image') }}</strong>
	                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Update
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection