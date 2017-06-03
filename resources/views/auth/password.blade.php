@extends('layouts.default')
@section('title', 'Password reset')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading">Password reset</div>
        <div class="panel-body">
          @include('shared._errors')
          <form action="{{route('password.reset')}}" method="post">
            {{csrf_field()}}

            <div class="form-group">
              <label class="col-md-4 control-label">Email: </label>
              <div class="col-md-6">
                <input type="email" class="form-control" name="email" value="{{old('email')}}">
              </div>
            </div>

            <div class="form-group">
              <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary">Reset</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@stop
