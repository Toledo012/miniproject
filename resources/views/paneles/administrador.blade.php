<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-raph-green">Resumen</p>
            <h1 class="mt-2 text-3xl font-semibold tracking-tight text-slate-950">Vista general</h1>
        </div>
    </x-slot>

    <div class="page-section">
        <div class="mx-auto max-w-7xl space-y-6">
            <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                <article class="glass-card p-6"><p class="text-sm text-slate-500">Usuarios</p><p class="mt-3 text-4xl font-semibold text-slate-950">{{ $totalUsuarios }}</p></article>
                <article class="glass-card p-6"><p class="text-sm text-slate-500">Productos</p><p class="mt-3 text-4xl font-semibold text-slate-950">{{ $totalProductos }}</p></article>
                <article class="glass-card p-6"><p class="text-sm text-slate-500">Categorias</p><p class="mt-3 text-4xl font-semibold text-slate-950">{{ $totalCategorias }}</p></article>
                <article class="glass-card p-6"><p class="text-sm text-slate-500">Ventas</p><p class="mt-3 text-4xl font-semibold text-slate-950">{{ $totalVentas }}</p></article>
            </section>

            <section class="grid gap-6 xl:grid-cols-[0.95fr_1.05fr]">
                <div class="glass-card p-6">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-raph-green">Actividad reciente</p>
                            <h2 class="mt-2 text-2xl font-semibold text-slate-950">Nuevas cuentas</h2>
                        </div>
                        <a href="{{ route('usuarios.index') }}" class="text-sm font-medium text-raph-green-dark transition hover:text-raph-green">Abrir usuarios</a>
                    </div>

                    <div class="mt-6 space-y-3">
                        @foreach ($ultimosUsuarios as $usuario)
                            <div class="rounded-[22px] border border-white/80 bg-white/80 p-4">
                                <p class="font-semibold text-slate-900">{{ $usuario->nombre }} {{ $usuario->apellidos }}</p>
                                <p class="mt-1 text-sm text-slate-500">{{ $usuario->correo }}</p>
                                <p class="mt-2 text-xs uppercase tracking-[0.22em] text-slate-400">{{ $usuario->rol }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="glass-card p-6">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-raph-green">Operacion</p>
                            <h2 class="mt-2 text-2xl font-semibold text-slate-950">Ultimas ventas</h2>
                        </div>
                        <a href="{{ route('ventas.index') }}" class="text-sm font-medium text-raph-green-dark transition hover:text-raph-green">Abrir ventas</a>
                    </div>

                    <div class="mt-6 space-y-3">
                        @foreach ($ultimasVentas as $venta)
                            <div class="rounded-[22px] border border-white/80 bg-white/80 p-4">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <p class="font-semibold text-slate-900">{{ $venta->producto->nombre }}</p>
                                        <p class="mt-1 text-sm text-slate-500">Cliente: {{ $venta->cliente->nombre }} {{ $venta->cliente->apellidos }}</p>
                                        <p class="mt-1 text-sm text-slate-500">Vendedor: {{ $venta->vendedor->nombre }} {{ $venta->vendedor->apellidos }}</p>
                                    </div>
                                    <span class="text-sm font-semibold text-slate-900">${{ number_format((float) $venta->total, 2) }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
