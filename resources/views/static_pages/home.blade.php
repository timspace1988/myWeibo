@extends('layouts.default')
@section('title', 'Home')
@section('content')
  <div class="jumbotron">
    <h1>Enjoy Weibo</h1>
    <p class="lead">
      This is a simulated <a href="#">Weibo</a> application
    </p>
    <p>
      Start your journey here.
    </p>
    <p>
      <a href="{{route('signup')}}" class="btn btn-lg btn-success" role="button">Sign up</a>
    </p>
  </div>

@stop
