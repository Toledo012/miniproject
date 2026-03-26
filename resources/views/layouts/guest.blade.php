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
    <body class="font-sans text-slate-900 antialiased">
        <div class="relative flex min-h-screen items-center justify-center overflow-hidden px-4 py-10 sm:px-6 lg:px-8">
            <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(116,172,66,0.18),transparent_32%),radial-gradient(circle_at_bottom_right,rgba(93,136,77,0.18),transparent_28%)]"></div>
            <div class="relative w-full max-w-6xl">
                <div class="grid items-center gap-8 lg:grid-cols-[0.95fr_0.75fr]">
                    <section class="hidden lg:block">
                        <div class="max-w-xl">
                            <span class="raph-pill">RAPH Commerce</span>
                            <h1 class="mt-6 text-5xl font-semibold tracking-tight text-slate-950">Accede y sigue donde te quedaste.</h1>
                            <p class="mt-6 text-lg leading-8 text-slate-600">
                                Todo listo para entrar, continuar tu compra o revisar tu actividad sin distracciones.
                            </p>
                            <div class="mt-10">
                                <a href="{{ route('home') }}" class="raph-button-secondary">Volver al inicio</a>
                            </div>
                        </div>
                    </section>

                    <div class="glass-card mx-auto w-full max-w-xl p-6 sm:p-8">
                        <div class="flex flex-col items-center text-center">
                            <a href="{{ route('home') }}" class="transition hover:scale-[1.01]">
                                <x-application-logo class="h-24 w-auto sm:h-28" />
                            </a>
                            <p class="mt-4 max-w-sm text-sm leading-6 text-slate-500">Entra para seguir comprando, revisar tu actividad o continuar tu trabajo.</p>
                        </div>

                        <div class="mt-8">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
