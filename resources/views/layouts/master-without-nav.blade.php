<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-topbar="light">

    <head>
    <meta charset="utf-8" />
    <title>@yield('title') | Whatsapp Api</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Whatsapp API" name="description" />
    <meta content=" Adam Innovations" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('assets/images/logo.png')}}">
        @include('layouts.head-css')
  </head>

    @yield('body')

    @yield('content')

    @include('layouts.vendor-scripts')
    </body>
</html>
