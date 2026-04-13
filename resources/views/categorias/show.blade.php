<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-raph-green">Organizacion</p>
            <h1 class="mt-2 text-3xl font-semibold tracking-tight text-slate-950">{{ $categoria->nombre }}</h1>
        </div>
    </x-slot>

    <div class="page-section">
        <div class="mx-auto max-w-7xl space-y-6">
            <section class="glass-card p-6 sm:p-8">
                <p class="max-w-3xl text-base leading-8 text-slate-600">{{ $categoria->descripcion }}</p>
            </section>

            <section class="glass-card p-6 sm:p-8">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-raph-green">Productos relacionados</p>
                        <h2 class="mt-2 text-2xl font-semibold text-slate-950">{{ $categoria->productos->count() }} resultados</h2>
                    </div>
                    <a href="{{ route('categorias.index') }}" class="raph-button-secondary">Volver</a>
                </div>

                <div class="mt-6 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                    @forelse ($categoria->productos as $producto)
                        <article class="rounded-[28px] border border-white/80 bg-white/80 p-5 shadow-sm">
                            <h3 class="text-lg font-semibold text-slate-950">{{ $producto->nombre }}</h3>
                            <p class="mt-2 text-sm text-slate-600">{{ \Illuminate\Support\Str::limit($producto->descripcion, 100) }}</p>
                            <p class="mt-4 text-sm text-slate-500">Vendedor: {{ $producto->vendedor->nombre }} {{ $producto->vendedor->apellidos }}</p>
                            <div class="mt-5 flex items-center justify-between">
                                <span class="font-semibold text-slate-950">${{ number_format((float) $producto->precio, 2) }}</span>
                                <a href="{{ route('productos.show', $producto) }}" class="text-sm font-medium text-raph-green-dark transition hover:text-raph-green">Ver</a>
                            </div>
                        </article>
                    @empty
                        <p class="text-sm text-slate-500">Esta categoria aun no tiene productos asociados.</p>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
