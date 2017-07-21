@extends('layouts.default')
@section('title', 'Home')
@section('content')

  @if(Auth::check())
    <div class="row">
      <div class="col-md-8">
        <section class="status_form">
          @include('shared._status_form')

        </section>
        <h3>Statuses list</h3>
        @include('shared._feed')
      </div>
      <aside class="col-md-4">
        <section class="user_info">
          @include('shared._user_info', ['user'=>Auth::user()])
        </section>
        <section class="stats">
          @include('shared._stats', ['user' => Auth::user()])
        </section>
      </aside>
    </div>
    @include('statuses._modals')
  @else
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
  @endif


@stop
