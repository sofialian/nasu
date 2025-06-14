<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="shortcut icon" href="{{ asset('logo.ico') }}" type="image/x-icon">


    <!-- Scripts -->
    @vite(['resources/css/app.css',  'resources/css/styles.css', 'resources/js/app.js'])
</head>

<body class="font-code antialiased bg-primary-light min-h-screen flex flex-col">

    <div class="flex-1 flex flex-col">
        <div class="flex flex-col justify-center items-center flex-1">
            <div class="max-h-screen flex flex-col sm:justify-center items-center pt-6">
                <div class="animate-bounce">
                    <a href="/">
                        <x-application-logo class="w-14 h-14" />
                    </a>
                </div>
                <div class="w-full sm:max-w-md mt-2 px-6 py-2 overflow-hidden">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
    <!-- Footer positioned at bottom -->
    @include('layouts.footer')
</body>

</html>