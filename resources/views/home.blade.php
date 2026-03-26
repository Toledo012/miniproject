<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tienda - Inicio</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900">
    @auth
        @include('layouts.navigation')
    @endauth

    <div class="max-w-6xl mx-auto p-6 space-y-6">
        @guest
            <header class="bg-white p-6 rounded-lg shadow">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-bold">Tienda E-commerce</h1>
                        <p class="text-gray-600 mt-1">Catalogo publico y acceso por roles.</p>
                    </div>
                    <nav class="flex items-center gap-3">
                        <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Iniciar sesion</a>
                        <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Registrarse</a>
                    </nav>
                </div>
            </header>
        @endguest

        <section class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-2xl font-semibold text-center mb-6">Sobre Nosotros</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <article class="border rounded-md p-4">
                    <h3 class="text-lg font-semibold mb-2">Quienes somos</h3>
                    <p class="text-gray-700">{{ $siteContent['about_us'] }}</p>
                </article>
                <article class="border rounded-md p-4">
                    <h3 class="text-lg font-semibold mb-2">Mision</h3>
                    <p class="text-gray-700">{{ $siteContent['mission'] }}</p>
                </article>
                <article class="border rounded-md p-4">
                    <h3 class="text-lg font-semibold mb-2">Vision</h3>
                    <p class="text-gray-700">{{ $siteContent['vision'] }}</p>
                </article>
            </div>
        </section>

        <section class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-3xl font-semibold">¡Los Productos Mas Vendidos!</h2>
                @auth
                    @if (auth()->user()->isCliente())
                        <a href="{{ route('client.products.index') }}" class="text-blue-600 hover:underline">Ver mas</a>
                    @else
                        <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline">Ver mas</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Ver mas</a>
                @endauth
            </div>
            @if ($products->isEmpty())
                <p class="text-gray-600">No hay productos activos publicados.</p>
            @else
                <div class="relative">
                    <div id="home-products-viewport" class="overflow-hidden">
                        <div id="home-products-track" class="flex gap-4 pb-2 transition-transform duration-300">
                            @foreach ($products as $product)
                                <article class="home-product-card border rounded-md p-4 shrink-0" style="display: flex; flex-direction: column; min-height: 380px;">
                                    <div style="height: 180px; background: #f3f4f6; border-radius: 6px; overflow: hidden; margin-bottom: 12px; display: flex; align-items: center; justify-content: center;">
                                        @if ($product->image_url)
                                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" style="width: 100%; height: 180px; object-fit: contain; object-position: center; display: block; background: #f3f4f6;">
                                        @else
                                            <div style="width: 100%; height: 180px; display: flex; align-items: center; justify-content: center; font-size: 12px; color: #6b7280;">Sin imagen</div>
                                        @endif
                                    </div>
                                    <h3 class="font-semibold" style="min-height: 48px;">{{ $product->name }}</h3>
                                    <p class="mt-2 text-xl font-semibold text-sky-600">${{ number_format((float) $product->price, 2) }}</p>
                                    <div class="mt-3 flex items-center justify-between gap-2" style="margin-top: auto;">
                                        @auth
                                            @if (auth()->user()->isCliente())
                                                <a href="{{ route('client.products.show', $product) }}" class="text-sm text-blue-600 hover:underline">Ver</a>
                                                <form method="POST" action="{{ route('client.cart.store', $product) }}">
                                                    @csrf
                                                    <button type="submit" class="bg-red-600 text-white text-sm px-3 py-2 rounded hover:bg-red-700">COMPRAR AHORA</button>
                                                </form>
                                            @else
                                                <a href="{{ route('dashboard') }}" class="text-sm text-blue-600 hover:underline">Panel</a>
                                            @endif
                                        @else
                                            <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:underline">Ver</a>
                                            <a href="{{ route('login') }}" class="bg-red-600 text-white text-sm px-3 py-2 rounded hover:bg-red-700">COMPRAR AHORA</a>
                                        @endauth
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </section>

        <section class="bg-white p-6 rounded-lg shadow space-y-3">
            <h2 class="text-xl font-semibold">Ubicacion</h2>
            <p class="text-gray-700">{{ $siteContent['location'] }}</p>
            <h2 class="text-xl font-semibold pt-2">Contactanos</h2>
            <p class="text-gray-700">{{ $siteContent['contact'] }}</p>
        </section>
    </div>
</body>
<script>
    (function () {
        const viewport = document.getElementById('home-products-viewport');
        const track = document.getElementById('home-products-track');
        if (!viewport || !track) return;

        const cards = Array.from(track.querySelectorAll('.home-product-card'));
        if (cards.length === 0) return;

        let index = 0;
        let visible = 1;
        const gap = 16;

        function getVisibleCount() {
            if (window.innerWidth >= 1280) return 5;
            if (window.innerWidth >= 1024) return 4;
            if (window.innerWidth >= 640) return 2;
            return 1;
        }

        function maxIndex() {
            return Math.max(0, cards.length - visible);
        }

        function layout() {
            visible = getVisibleCount();
            const viewportWidth = viewport.clientWidth;
            const cardWidth = (viewportWidth - (gap * (visible - 1))) / visible;

            cards.forEach((card) => {
                card.style.width = cardWidth + 'px';
            });

            if (index > maxIndex()) index = maxIndex();
            update();
        }

        function update() {
            const cardWidth = cards[0].offsetWidth;
            const offset = index * (cardWidth + gap);
            track.style.transform = `translateX(-${offset}px)`;
        }

        window.addEventListener('resize', layout);
        layout();
    })();
</script>
</html>
