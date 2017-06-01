<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>@yield('title', 'My Weibo') - A simulated Weibo app</title><!--second param is a default value-->
    <link rel="stylesheet" href="/css/app.css">
    @include('layouts._header')

    <div class="container">
      @yield('content')
      @include('layouts._footer')
    </div>

  </body>
</html>
