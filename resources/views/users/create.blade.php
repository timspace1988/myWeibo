@extends('layouts.default')
@section('title', 'Sign up')

@section('content')
<div class="col-md-offset-2 col-md-8">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h5>Sign up</h5>
    </div>
    <div class="panel-body">
      @include('shared._errors')
      <form action="{{route('users.store')}}" method="post">
        {{csrf_field()}}
        <div class="form-group">
          <label for="name">Name: </label>
          <input type="text" name="name" class="form-control" value="{{old('name')}}">
        </div>

        <div class="form-group">
          <label for="email">Email: </label>
          <input type="text" name="email" class="form-control" value="{{old('email')}}">
        </div>

        <div class="form-group">
          <label for="password">Password: </label>
          <input type="password" name="password" class="form-control" value="{{old('password')}}">
        </div>

        <div class="form-group">
          <label for="password_confirmation">Confirm password: </label>
          <input type="password" name="password_confirmation" class="form-control" value="{{old('password_confirmation')}}">
        </div>

        <button type="submit" class="btn btn-primary">Sign up</button>
      </form>
    </div>
  </div>
</div>
@stop
