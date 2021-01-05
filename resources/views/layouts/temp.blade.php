<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{asset('css/ionicons.min.css')}}">

    <link rel="stylesheet" href="{{asset('plugins/jquery-ui/jquery-ui.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/jquery-ui/jquery-ui.theme.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/jquery-ui/jquery-ui.structure.min.css')}}">

    <link rel="stylesheet" href="{{asset('plugins/bootstrap/css/bootstrap.min.css')}}">

</head>

<body>

    @yield('content')

    <!-- jQuery -->
    <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- jQuery UI -->
    <script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
    <!-- Jquery Validate -->
    <script src="{{asset('plugins/jquery-validation/jquery.validate.min.js')}}"></script>

    @stack('script')
</body>

</html>
