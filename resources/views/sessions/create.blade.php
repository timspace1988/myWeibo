@extends('layouts.default')
@section('title', 'Sign in')

@section('content')
<div class="col-md-offset-2 col-md-8">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h5>Sign in</h5>
    </div>
    <div class="panel-body">
      @include('shared._errors')

      <form action="{{route('login')}}" method="post">
        {{csrf_field()}}

        <div class="form-group">
          <label for="email">Email: </label>
          <input type="text" name="email" class="form-control" value="{{old('email')}}">
        </div>
        <div class="form-group">
          <label for="password">Password(<a href="{{route('password.reset')}}">Forget</a>): </label>
          <input type="password" name="password" class="form-control" value="{{old('password')}}">
        </div>
        <div class="checkbox">
          <label><input type="checkbox" name="remember"> Remember</label>
        </div>

        <button type="submit" class="btn btn-primary">Sign in</button>
      </form>

      <hr>

      <p>No account? <a href="{{route('signup')}}">Sign up</a></p>
    </div>
  </div>
</div>
@stop
