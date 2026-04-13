<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-raph-green">Catalogo</p>
            <h1 class="mt-2 text-3xl font-semibold tracking-tight text-slate-950">{{ $producto->nombre }}</h1>
        </div>
    </x-slot>

    <div class="page-section">
        <div class="mx-auto grid max-w-7xl gap-6 lg:grid-cols-[1fr_0.9fr]">
            <section class="glass-card p-6 sm:p-8">
                <div class="flex h-[26rem] items-center justify-center overflow-hidden rounded-[28px] bg-slate-100">
                    @if ($producto->imagen_url)
                        <img src="{{ $producto->imagen_url }}" alt="{{ $producto->nombre }}" class="h-full w-full object-contain">
                    @else
                        <span class="text-sm text-slate-400">Sin imagen</span>
                    @endif
                </div>
            </section>

            <section class="glass-card p-6 sm:p-8">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-sm text-slate-500">Vendedor</p>
                        <p class="mt-1 text-lg font-semibold text-slate-950">{{ $producto->vendedor->nombre }} {{ $producto->vendedor->apellidos }}</p>
                    </div>
                    <span class="text-2xl font-semibold text-slate-950">${{ number_format((float) $producto->precio, 2) }}</span>
                </div>

                <p class="mt-6 text-base leading-8 text-slate-600">{{ $producto->descripcion }}</p>

                <div class="mt-6 flex flex-wrap gap-2">
                    @foreach ($producto->categorias as $categoria)
                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-600">{{ $categoria->nombre }}</span>
                    @endforeach
                </div>

                <div class="mt-8 grid gap-4 sm:grid-cols-2">
                    <div class="rounded-[24px] border border-white/80 bg-white/80 p-4">
                        <p class="text-sm text-slate-500">Disponibles</p>
                        <p class="mt-2 text-2xl font-semibold text-slate-950">{{ $producto->existencia }}</p>
                    </div>
                    <div class="rounded-[24px] border border-white/80 bg-white/80 p-4">
                        <p class="text-sm text-slate-500">Ventas registradas</p>
                        <p class="mt-2 text-2xl font-semibold text-slate-950">{{ $producto->ventas->count() }}</p>
                    </div>
                </div>

                <div class="mt-8 flex flex-wrap gap-3">
                    @if (auth()->user()->esCliente() && $producto->existencia > 0)
                        <a href="{{ route('ventas.create', ['producto' => $producto->id]) }}" class="raph-button-primary">Comprar ahora</a>
                    @endif
                    @can('update', $producto)
                        <a href="{{ route('productos.edit', $producto) }}" class="raph-button-secondary">Editar</a>
                    @endcan
                    <a href="{{ route('productos.index') }}" class="raph-button-secondary">Volver</a>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
