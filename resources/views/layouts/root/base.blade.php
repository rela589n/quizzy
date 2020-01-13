<!DOCTYPE html>
<html lang="ua">
<head>
    <meta charset="UTF-8">
    <title> @yield('title') </title>
    <link rel="stylesheet" type="text/css" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>
<body class="@yield('body-class')">

@yield('menu')

@yield('content')

@stack('bottom_scripts')
</body>
</html>
