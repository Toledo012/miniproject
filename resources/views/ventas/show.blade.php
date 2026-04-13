<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-raph-green">Ventas</p>
            <h1 class="mt-2 text-3xl font-semibold tracking-tight text-slate-950">Detalle de venta #{{ $venta->id }}</h1>
        </div>
    </x-slot>

    <div class="page-section">
        <div class="mx-auto max-w-5xl">
            <div class="glass-card p-6 sm:p-8">
                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="rounded-[24px] border border-white/80 bg-white/80 p-5">
                        <p class="text-sm text-slate-500">Producto</p>
                        <p class="mt-2 text-xl font-semibold text-slate-950">{{ $venta->producto->nombre }}</p>
                    </div>
                    <div class="rounded-[24px] border border-white/80 bg-white/80 p-5">
                        <p class="text-sm text-slate-500">Total</p>
                        <p class="mt-2 text-xl font-semibold text-slate-950">${{ number_format((float) $venta->total, 2) }}</p>
                    </div>
                    <div class="rounded-[24px] border border-white/80 bg-white/80 p-5">
                        <p class="text-sm text-slate-500">Cliente</p>
                        <p class="mt-2 text-xl font-semibold text-slate-950">{{ $venta->cliente->nombre }} {{ $venta->cliente->apellidos }}</p>
                        <p class="mt-1 text-sm text-slate-500">{{ $venta->cliente->correo }}</p>
                    </div>
                    <div class="rounded-[24px] border border-white/80 bg-white/80 p-5">
                        <p class="text-sm text-slate-500">Vendedor</p>
                        <p class="mt-2 text-xl font-semibold text-slate-950">{{ $venta->vendedor->nombre }} {{ $venta->vendedor->apellidos }}</p>
                        <p class="mt-1 text-sm text-slate-500">{{ $venta->vendedor->correo }}</p>
                    </div>
                </div>

                <div class="mt-6 rounded-[24px] border border-white/80 bg-white/80 p-5">
                    <p class="text-sm text-slate-500">Fecha</p>
                    <p class="mt-2 text-lg font-semibold text-slate-950">{{ $venta->fecha->format('d/m/Y') }}</p>
                </div>

                <div class="mt-8 flex flex-wrap gap-3">
                    @can('update', $venta)
                        <a href="{{ route('ventas.edit', $venta) }}" class="raph-button-primary">Editar</a>
                    @endcan
                    <a href="{{ route('ventas.index') }}" class="raph-button-secondary">Volver</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
