<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Quasar + Laravel + Vite</title>

    @php
        $cssFiles = glob(public_path('quasar/assets/index*.css'));
        $jsFiles = glob(public_path('quasar/assets/index*.js'));
    @endphp

    @foreach ($cssFiles as $file)
        <link rel="stylesheet" href="{{ str_replace(public_path(), '', $file) }}">
    @endforeach
</head>
<body>
    <div id="q-app"></div>

    @foreach ($jsFiles as $file)
        <script type="module" crossorigin src="{{ str_replace(public_path(), '', $file) }}"></script>
    @endforeach
</body>
</html>
