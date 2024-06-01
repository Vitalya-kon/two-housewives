<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="yandex-verification" content="829e88268edf5069" />
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon"/>
    <title>Две хозяюшки</title>
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://getbootstrap.com/docs/5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('build/assets/app-b182140e.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('build/assets/app-fabb6531.css') }}" rel="stylesheet"> --}}
    {{-- @vite(['resources/js/app.js']) --}}
    <script src="{{ asset('build/assets/app-5cdb3ddc.js') }}" defer></script>

    {{-- @vite(['build/assets/app-5cdb3ddc.js','build/assets/app-fabb6531.css','build/assets/app-b182140e.css']) --}}
</head>
<body>
    <div id="app"></div>
</body>
</html>
