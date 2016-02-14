<!DOCTYPE html>
<html lang="en" {!! isset($ngController)?"ng-app=\"ngApp\" ng-controller=\"$ngController\" ng-cloak":"" !!} >
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
      @if (isset($title))
        {{$title}}
      @else
        Laralog
      @endif
    </title>

    <meta name="description" content="Source code generated using layoutit.com">
    <meta name="author" content="LayoutIt!">

    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">

  </head>
  <body>
    <div class="container-fluid">

    @include('layouts.header')

    @yield('main')

    @include('layouts.footer')

    </div>
    <script src="/js/jquery.min.js"></script>
    <script src="/js/jquery.validate.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/angular.min.js"></script>
    <script src="/js/angular-sanitize.min.js"></script>
    <script src="/js/ng-infinite-scroll.min.js"></script>
    @if (isset($script))
    {!! $script !!}
    @endif
    <script src="/js/scripts.js"></script>
  </body>
</html>