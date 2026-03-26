<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="theme-color" content="#f5f7f2">

        <title>RAPH</title>
        <link rel="icon" type="image/svg+xml" href="{{ asset('raph-favicon.svg') }}">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="relative min-h-screen overflow-hidden">
            <div class="pointer-events-none absolute inset-x-0 top-0 h-80 bg-gradient-to-b from-raph-green/10 via-white/0 to-transparent"></div>
            <div class="pointer-events-none absolute left-[-6rem] top-24 h-72 w-72 rounded-full bg-raph-green/10 blur-3xl"></div>
            <div class="pointer-events-none absolute right-[-8rem] top-12 h-96 w-96 rounded-full bg-raph-green-dark/10 blur-3xl"></div>

            @include('layouts.navigation')

            @isset($header)
                <header class="relative z-10 border-b border-white/60 bg-white/35 backdrop-blur-xl">
                    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main class="relative z-10">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
