<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @isset($title)
        {{ $title }} |
        @endisset
        {{ config('app.name') }}
    </title>

    <!-- Favicons -->
    <link rel="icon" type="image/x-icon" href="{{ asset('/vendor/trov/images/favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/vendor/trov/images/favicon.png') }}">

    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="{{ asset('vendor/trov/css/trov.css') }}" rel="stylesheet" />
</head>

<body class="flex h-full font-sans text-white bg-gray-900 antialised">
    <div class="flex flex-col justify-center w-full h-full max-w-md p-10 bg-right-bottom bg-no-repeat bg-contain border-r-4 border-pink-600" style="background-image: url({{ asset('vendor/trov/images/cms-geometric.png') }});">
        <h1 class="mb-6 text-3xl font-bold leading-tight">{{ config('app.name') }}</h1>
        @yield('body')
    </div>
    <div class="relative flex-1 hidden w-0 lg:block">
        <img class="absolute inset-0 object-cover w-full h-full" src="https://source.unsplash.com/featured/?wallpaper" alt="">
    </div>
</body>

</html>