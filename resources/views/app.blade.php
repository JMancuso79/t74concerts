<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-100">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <meta property="og:title" content="{{session('page_data.title')}}">
        <meta property="og:description" content="{{session('page_data.description')}}">
        <meta property="og:image" content="{{session('page_data.image')}}">
        <meta property="og:url" content="{{session('page_data.url')}}">
        <meta name="description" content="{{session('page_data.description')}}">

        <title>{{session('page_data.title')}}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <!-- Scripts -->
        @routes
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased dark:bg-black h-full">
        @inertia
    </body>
</html>


