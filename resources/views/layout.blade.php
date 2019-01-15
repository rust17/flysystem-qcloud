<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Flysystem-Qcloud-User-Interface') }}</title>

    <!-- styles -->
    <link rel="stylesheet" href="/vendor/circle33/css/main.css">
</head>
<body>

    <div id="app">

        @include('qcloud::nav')

        @yield('content')
    </div>

    <!-- scripts -->
    <script src="/vendor/circle33/js/app.js"></script>
</body>
</html>