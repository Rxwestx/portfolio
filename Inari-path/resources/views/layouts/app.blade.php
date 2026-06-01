<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Inari-path') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+1:wght@300;400;500&family=Montserrat:wght@500;600&display=swap" rel="stylesheet">
    <!-- Scripts -->
    @vite(['resources/css/app.css','resources/css/custom.css', 'resources/js/app.js'])
</head>

<body class="m-plus-1p-light antialiased inari-page-bg text-gray-600">
    <div class="min-h-screen">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="inari-page-header">
                <div class="mx-auto w-full max-w-5xl px-4 py-5 sm:px-6 sm:py-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main class="inari-page-shell px-4 pb-10 sm:px-6 sm:pb-12 lg:px-8">
            {{ $slot }}
        </main>
    </div>
</body>

</html>
