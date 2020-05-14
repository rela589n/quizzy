<!DOCTYPE html>
<html lang="ua">
<head>
    <meta charset="UTF-8">
    <title> @yield('title') </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @section('head_styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('fontawesome/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    @show
</head>
<body class="@yield('body-class')">

@yield('menu')

@yield('content')

@section('bottom-scripts')
    <script defer src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
@show
</body>
</html>
