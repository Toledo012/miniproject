<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-raph-green">Tu espacio</p>
            <h1 class="mt-2 text-3xl font-semibold tracking-tight text-slate-950">Compras y recomendaciones</h1>
        </div>
    </x-slot>

    <div class="page-section">
        <div class="mx-auto max-w-7xl space-y-6">
            <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                <article class="glass-card p-6"><p class="text-sm text-slate-500">Compras realizadas</p><p class="mt-3 text-4xl font-semibold text-slate-950">{{ $comprasRealizadas }}</p></article>
                <article class="glass-card p-6"><p class="text-sm text-slate-500">Gasto acumulado</p><p class="mt-3 text-4xl font-semibold text-slate-950">${{ number_format($gastoTotal, 2) }}</p></article>
                <article class="glass-card p-6"><p class="text-sm text-slate-500">Productos disponibles</p><p class="mt-3 text-4xl font-semibold text-slate-950">{{ $productosDisponibles }}</p></article>
            </section>

            <section class="grid gap-6 xl:grid-cols-[0.95fr_1.05fr]">
                <div class="glass-card p-6">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-raph-green">Historial</p>
                            <h2 class="mt-2 text-2xl font-semibold text-slate-950">Ultimas compras</h2>
                        </div>
                        <a href="{{ route('ventas.index') }}" class="text-sm font-medium text-raph-green-dark transition hover:text-raph-green">Ver historial</a>
                    </div>

                    <div class="mt-6 space-y-3">
                        @forelse ($ultimasCompras as $venta)
                            <div class="rounded-[22px] border border-white/80 bg-white/80 p-4">
                                <p class="font-semibold text-slate-900">{{ $venta->producto->nombre }}</p>
                                <p class="mt-1 text-sm text-slate-500">Vendedor: {{ $venta->vendedor->nombre }} {{ $venta->vendedor->apellidos }}</p>
                                <div class="mt-3 flex items-center justify-between gap-4 text-sm">
                                    <span class="text-slate-500">{{ $venta->fecha->format('d/m/Y') }}</span>
                                    <span class="font-semibold text-slate-900">${{ number_format((float) $venta->total, 2) }}</span>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-slate-500">Todavia no hay compras registradas.</p>
                        @endforelse
                    </div>
                </div>

                <div class="glass-card p-6">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-raph-green">Sugeridos</p>
                            <h2 class="mt-2 text-2xl font-semibold text-slate-950">Para seguir explorando</h2>
                        </div>
                        <a href="{{ route('productos.index') }}" class="text-sm font-medium text-raph-green-dark transition hover:text-raph-green">Ver catalogo</a>
                    </div>

                    <div class="mt-6 grid gap-4 sm:grid-cols-2">
                        @foreach ($productosDestacados as $producto)
                            <article class="rounded-[22px] border border-white/80 bg-white/80 p-4">
                                <h3 class="font-semibold text-slate-900">{{ $producto->nombre }}</h3>
                                <p class="mt-2 text-sm text-slate-500">{{ $producto->vendedor->nombre }} {{ $producto->vendedor->apellidos }}</p>
                                <div class="mt-4 flex items-center justify-between gap-3">
                                    <span class="font-semibold text-slate-900">${{ number_format((float) $producto->precio, 2) }}</span>
                                    <a href="{{ route('ventas.create', ['producto' => $producto->id]) }}" class="text-sm font-medium text-raph-green-dark transition hover:text-raph-green">Comprar</a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
