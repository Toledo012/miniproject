<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-raph-green">Operacion</p>
            <h1 class="mt-2 text-3xl font-semibold tracking-tight text-slate-950">Control comercial</h1>
        </div>
    </x-slot>

    <div class="page-section">
        <div class="mx-auto max-w-7xl space-y-6">
            <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                <article class="glass-card p-6"><p class="text-sm text-slate-500">Productos</p><p class="mt-3 text-4xl font-semibold text-slate-950">{{ $totalProductos }}</p></article>
                <article class="glass-card p-6"><p class="text-sm text-slate-500">Categorias activas</p><p class="mt-3 text-4xl font-semibold text-slate-950">{{ $totalCategorias }}</p></article>
                <article class="glass-card p-6"><p class="text-sm text-slate-500">Ventas</p><p class="mt-3 text-4xl font-semibold text-slate-950">{{ $totalVentas }}</p></article>
                <article class="glass-card p-6"><p class="text-sm text-slate-500">Ventas de hoy</p><p class="mt-3 text-4xl font-semibold text-slate-950">${{ number_format($ventasHoy, 2) }}</p></article>
            </section>

            <section class="grid gap-6 xl:grid-cols-[0.95fr_1.05fr]">
                <div class="glass-card p-6">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-raph-green">Inventario</p>
                            <h2 class="mt-2 text-2xl font-semibold text-slate-950">Productos recientes</h2>
                        </div>
                        <a href="{{ route('productos.index') }}" class="text-sm font-medium text-raph-green-dark transition hover:text-raph-green">Abrir catalogo</a>
                    </div>

                    <div class="mt-6 space-y-3">
                        @foreach ($productos as $producto)
                            <div class="rounded-[22px] border border-white/80 bg-white/80 p-4">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <p class="font-semibold text-slate-900">{{ $producto->nombre }}</p>
                                        <p class="mt-1 text-sm text-slate-500">{{ $producto->categorias->pluck('nombre')->join(', ') }}</p>
                                    </div>
                                    <span class="text-sm font-semibold text-slate-900">{{ $producto->existencia }} uds</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="glass-card p-6">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-raph-green">Ventas</p>
                            <h2 class="mt-2 text-2xl font-semibold text-slate-950">Movimiento reciente</h2>
                        </div>
                        <a href="{{ route('ventas.index') }}" class="text-sm font-medium text-raph-green-dark transition hover:text-raph-green">Abrir ventas</a>
                    </div>

                    <div class="mt-6 space-y-3">
                        @foreach ($ultimasVentas as $venta)
                            <div class="rounded-[22px] border border-white/80 bg-white/80 p-4">
                                <p class="font-semibold text-slate-900">{{ $venta->producto->nombre }}</p>
                                <p class="mt-1 text-sm text-slate-500">Cliente: {{ $venta->cliente->nombre }} {{ $venta->cliente->apellidos }}</p>
                                <div class="mt-3 flex items-center justify-between gap-4 text-sm">
                                    <span class="text-slate-500">{{ $venta->fecha->format('d/m/Y') }}</span>
                                    <span class="font-semibold text-slate-900">${{ number_format((float) $venta->total, 2) }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
