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
    @vite(['resources/css/app.css', 'resources/css/custom.css', 'resources/js/app.js'])
</head>

<body class="m-plus-1p-light antialiased inari-page-bg text-gray-600">
    <div class="flex min-h-screen flex-col items-center px-4 pt-6 sm:justify-center sm:px-6 sm:pt-0">
        <div>
            <a href="/">
                <x-application-logo class="!w-32 text-gray-500" />
            </a>
        </div>

        <div class="inari-auth-card mt-6 w-full max-w-md overflow-hidden px-5 py-6 sm:px-6 sm:py-8">
            {{ $slot }}
        </div>
    </div>
</body>

</html>
