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
                        <a href="{{ route('register') }}" class="raph-button-primary">Registrarse</a>
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
                                Compra con fluidez, descubre productos y manten todo en orden en un mismo lugar.
                            </h1>
                            <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-600">
                                Descubre novedades, revisa disponibilidad y compra con una experiencia clara de principio a fin.
                            </p>

                            <div class="mt-10 flex flex-wrap gap-4">
                                @guest
                                    <a href="{{ route('register') }}" class="raph-button-primary">Crear cuenta</a>
                                    <a href="{{ route('login') }}" class="raph-button-secondary">Entrar a RAPH</a>
                                @else
                                    <a href="{{ route('dashboard') }}" class="raph-button-primary">Ir a mi panel</a>
                                    @if (auth()->user()->isCliente())
                                        <a href="{{ route('client.products.index') }}" class="raph-button-secondary">Ver catalogo</a>
                                    @endif
                                @endguest
                            </div>

                            <div class="mt-12 grid gap-4 sm:grid-cols-3">
                                <article class="glass-card p-5">
                                    <p class="text-sm text-slate-500">Catalogo</p>
                                    <p class="mt-2 text-base font-semibold text-slate-900">Explora productos, compara precios y encuentra lo que buscas rapido.</p>
                                </article>
                                <article class="glass-card p-5">
                                    <p class="text-sm text-slate-500">Compras</p>
                                    <p class="mt-2 text-base font-semibold text-slate-900">Carrito, pedidos y seguimiento en una experiencia continua y sin friccion.</p>
                                </article>
                                <article class="glass-card p-5">
                                    <p class="text-sm text-slate-500">Control</p>
                                    <p class="mt-2 text-base font-semibold text-slate-900">Inventario, pedidos y contenido siempre a la mano cuando los necesitas.</p>
                                </article>
                            </div>
                        </div>

                        <div class="glass-card p-6 sm:p-8">
                            <div class="rounded-[30px] bg-gradient-to-br from-slate-950 via-slate-800 to-raph-green-dark p-8 text-white">
                                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-white/70">RAPH</p>
                                <h2 class="mt-4 text-3xl font-semibold tracking-tight">Encuentra lo que necesitas y compra sin complicaciones.</h2>
                                <div class="mt-8 space-y-4">
                                    <div class="rounded-[24px] border border-white/10 bg-white/10 p-4 backdrop-blur">
                                        <p class="text-sm font-semibold">Catalogo claro</p>
                                        <p class="mt-1 text-sm text-white/75">Productos, precios y disponibilidad visibles desde el primer momento.</p>
                                    </div>
                                    <div class="rounded-[24px] border border-white/10 bg-white/10 p-4 backdrop-blur">
                                        <p class="text-sm font-semibold">Compra continua</p>
                                        <p class="mt-1 text-sm text-white/75">Carrito, pedidos y seguimiento listos para continuar sin perder tiempo.</p>
                                    </div>
                                    <div class="rounded-[24px] border border-white/10 bg-white/10 p-4 backdrop-blur">
                                        <p class="text-sm font-semibold">Informacion a la mano</p>
                                        <p class="mt-1 text-sm text-white/75">Ubicacion, contacto y datos esenciales siempre visibles cuando los buscas.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="page-section">
                <div class="mx-auto grid max-w-7xl gap-6 lg:grid-cols-2">
                    <div class="glass-card p-8">
                        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-raph-green">Quienes somos</p>
                        <h2 class="mt-3 text-3xl font-semibold tracking-tight text-slate-950">Una tienda digital pensada para crecer con orden.</h2>
                        <p class="mt-4 text-base leading-8 text-slate-600">{{ $siteContent['about_us'] }}</p>
                    </div>
                    <div class="grid gap-6 sm:grid-cols-2">
                        <article class="glass-card p-8">
                            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-raph-green">Mision</p>
                            <p class="mt-4 text-base leading-8 text-slate-600">{{ $siteContent['mission'] }}</p>
                        </article>
                        <article class="glass-card p-8">
                            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-raph-green">Vision</p>
                            <p class="mt-4 text-base leading-8 text-slate-600">{{ $siteContent['vision'] }}</p>
                        </article>
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
                        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-raph-green">Contactanos</p>
                        <p class="mt-4 text-base leading-8 text-slate-600">{{ $siteContent['contact'] }}</p>
                    </article>
                </div>
            </section>

            @auth
                <section class="page-section pt-0">
                    <div class="mx-auto max-w-7xl">
                        <div class="glass-card p-8 sm:p-10">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-raph-green">Recomendados</p>
                                    <h2 class="mt-2 text-3xl font-semibold tracking-tight text-slate-950">Productos activos en RAPH</h2>
                                </div>
                                @if (auth()->user()->isCliente())
                                    <a href="{{ route('client.products.index') }}" class="text-sm font-medium text-raph-green-dark transition hover:text-raph-green">Ir al catalogo completo</a>
                                @else
                                    <a href="{{ route('dashboard') }}" class="text-sm font-medium text-raph-green-dark transition hover:text-raph-green">Ir a mi panel</a>
                                @endif
                            </div>

                            <div class="mt-6 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                                @forelse ($products->take(4) as $product)
                                    <article class="rounded-[28px] border border-white/80 bg-white/80 p-4 shadow-sm">
                                        <div class="flex h-48 items-center justify-center overflow-hidden rounded-[22px] bg-slate-100">
                                            @if ($product->image_url)
                                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-full w-full object-contain">
                                            @else
                                                <span class="text-sm text-slate-400">Sin imagen</span>
                                            @endif
                                        </div>
                                        <h3 class="mt-4 text-lg font-semibold text-slate-900">{{ $product->name }}</h3>
                                        <p class="mt-2 text-sm text-slate-500">{{ \Illuminate\Support\Str::limit($product->description ?: 'Producto disponible actualmente en RAPH.', 82) }}</p>
                                        <div class="mt-4 flex items-center justify-between gap-3">
                                            <span class="text-base font-semibold text-slate-950">${{ number_format((float) $product->price, 2) }}</span>
                                            @if (auth()->user()->isCliente())
                                                <a href="{{ route('client.products.show', $product) }}" class="text-sm font-medium text-raph-green-dark transition hover:text-raph-green">Ver detalle</a>
                                            @else
                                                <a href="{{ route('dashboard') }}" class="text-sm font-medium text-raph-green-dark transition hover:text-raph-green">Panel</a>
                                            @endif
                                        </div>
                                    </article>
                                @empty
                                    <p class="text-sm text-slate-500">Todavia no hay productos activos disponibles.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </section>
            @endauth
        </main>
    </div>
</body>
</html>
