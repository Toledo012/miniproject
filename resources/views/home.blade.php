<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f5f7f2">
    <title>RAPH</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('raph-favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-slate-900 antialiased">
    <div class="relative min-h-screen overflow-hidden">
        <div class="pointer-events-none absolute inset-x-0 top-0 h-[34rem] bg-[radial-gradient(circle_at_top_left,rgba(116,172,66,0.18),transparent_34%),radial-gradient(circle_at_top_right,rgba(93,136,77,0.14),transparent_30%)]"></div>

        @auth
            @include('layouts.navigation')
        @else
            <header class="relative z-20 border-b border-white/60 bg-white/55 backdrop-blur-2xl">
                <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
                    <a href="{{ route('home') }}" class="transition hover:opacity-90">
                        <x-application-logo class="h-11 w-auto" />
                    </a>
                    <nav class="hidden items-center gap-3 sm:flex">
                        <a href="{{ route('login') }}" class="raph-button-secondary">Iniciar sesion</a>
                        <a href="{{ route('register') }}" class="raph-button-primary">Crear cuenta</a>
                    </nav>
                </div>
            </header>
        @endauth

        <main class="relative z-10">
            <section class="page-section pt-10 lg:pt-16">
                <div class="mx-auto max-w-7xl">
                    <div class="grid items-center gap-10 lg:grid-cols-[1.05fr_0.95fr]">
                        <div>
                            <span class="raph-pill">RAPH</span>
                            <h1 class="mt-6 max-w-4xl text-5xl font-semibold tracking-tight text-slate-950 sm:text-6xl lg:text-7xl">
                                Productos que se integran a tu dia a dia.
                            </h1>
                            <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-600">
                                Explora tecnologia, oficina, hogar y accesorios con una experiencia clara, rapida y enfocada en lo esencial.
                            </p>

                            <div class="mt-10 flex flex-wrap gap-4">
                                @guest
                                    <a href="{{ route('register') }}" class="raph-button-primary">Comenzar</a>
                                    <a href="{{ route('login') }}" class="raph-button-secondary">Entrar</a>
                                @else
                                    <a href="{{ route('dashboard') }}" class="raph-button-primary">Continuar</a>
                                    <a href="{{ route('productos.index') }}" class="raph-button-secondary">Ver catalogo</a>
                                @endguest
                            </div>
                        </div>

                        <div class="glass-card p-6 sm:p-8">
                            <div class="rounded-[30px] bg-gradient-to-br from-slate-950 via-slate-800 to-raph-green-dark p-8 text-white">
                                <h2 class="text-3xl font-semibold tracking-tight">Nuestra esencia</h2>
                                <div class="mt-8 space-y-4">
                                    <div class="rounded-[24px] border border-white/10 bg-white/10 p-4 backdrop-blur">
                                        <p class="text-sm font-semibold">Quienes somos</p>
                                        <p class="mt-1 text-sm text-white/75">{{ $siteContent['about_us'] }}</p>
                                    </div>
                                    <div class="rounded-[24px] border border-white/10 bg-white/10 p-4 backdrop-blur">
                                        <p class="text-sm font-semibold">Mision</p>
                                        <p class="mt-1 text-sm text-white/75">{{ $siteContent['mission'] }}</p>
                                    </div>
                                    <div class="rounded-[24px] border border-white/10 bg-white/10 p-4 backdrop-blur">
                                        <p class="text-sm font-semibold">Vision</p>
                                        <p class="mt-1 text-sm text-white/75">{{ $siteContent['vision'] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="page-section">
                <div class="mx-auto grid max-w-7xl gap-6 lg:grid-cols-[0.8fr_1.2fr]">
                    <article class="glass-card p-8">
                        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-raph-green">Ubicacion</p>
                        <p class="mt-4 text-base leading-8 text-slate-600">{{ $siteContent['location'] }}</p>
                    </article>
                    <article class="glass-card p-8">
                        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-raph-green">Contacto</p>
                        <p class="mt-4 text-base leading-8 text-slate-600">{{ $siteContent['contact'] }}</p>
                    </article>
                </div>
            </section>

            <section class="page-section pt-0">
                <div class="mx-auto max-w-7xl">
                    <div class="glass-card p-8 sm:p-10">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-raph-green">Coleccion</p>
                                <h2 class="mt-2 text-3xl font-semibold tracking-tight text-slate-950">Selecciones recientes</h2>
                            </div>
                            <a href="{{ auth()->check() ? route('productos.index') : route('login') }}" class="text-sm font-medium text-raph-green-dark transition hover:text-raph-green">Abrir catalogo</a>
                        </div>

                        <div class="mt-6 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                            @forelse ($productos as $producto)
                                <article class="rounded-[28px] border border-white/80 bg-white/80 p-4 shadow-sm">
                                    <div class="flex h-48 items-center justify-center overflow-hidden rounded-[22px] bg-slate-100">
                                        @if ($producto->imagen_url)
                                            <img src="{{ $producto->imagen_url }}" alt="{{ $producto->nombre }}" class="h-full w-full object-contain">
                                        @else
                                            <span class="text-sm text-slate-400">Sin imagen</span>
                                        @endif
                                    </div>
                                    <h3 class="mt-4 text-lg font-semibold text-slate-900">{{ $producto->nombre }}</h3>
                                    <p class="mt-2 text-sm text-slate-500">{{ \Illuminate\Support\Str::limit($producto->descripcion, 80) }}</p>
                                    <div class="mt-4 flex flex-wrap gap-2">
                                        @foreach ($producto->categorias as $categoria)
                                            <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-600">{{ $categoria->nombre }}</span>
                                        @endforeach
                                    </div>
                                    <div class="mt-4 flex items-center justify-between gap-3">
                                        <span class="text-base font-semibold text-slate-950">${{ number_format((float) $producto->precio, 2) }}</span>
                                        <span class="text-sm text-slate-500">{{ $producto->existencia }} disponibles</span>
                                    </div>
                                </article>
                            @empty
                                <p class="text-sm text-slate-500">Todavia no hay productos publicados.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
