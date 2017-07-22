<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>@yield('title', 'My Weibo') - A simulated Weibo app</title><!--second param is a default value-->
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    @include('layouts._header')

    <div class="container">
      @include('shared._messages')
      @yield('content')
      @include('layouts._footer')
    </div>

    <script src="/js/app.js"></script>
    <script src="//twemoji.maxcdn.com/twemoji.min.js"></script>

  </body>
</html>
