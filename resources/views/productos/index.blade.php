<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-raph-green">Catalogo</p>
                <h1 class="mt-2 text-3xl font-semibold tracking-tight text-slate-950">Productos</h1>
            </div>
            @can('create', \App\Models\Producto::class)
                <a href="{{ route('productos.create') }}" class="raph-button-primary">Nuevo producto</a>
            @endcan
        </div>
    </x-slot>

    <div class="page-section">
        <div class="mx-auto max-w-7xl space-y-6">
            @if (session('status'))
                <div class="glass-card p-4 text-sm text-slate-600">{{ session('status') }}</div>
            @endif

            <section class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                @forelse ($productos as $producto)
                    <article class="glass-card p-5">
                        <div class="flex h-56 items-center justify-center overflow-hidden rounded-[24px] bg-slate-100">
                            @if ($producto->imagen_url)
                                <img src="{{ $producto->imagen_url }}" alt="{{ $producto->nombre }}" class="h-full w-full object-contain">
                            @else
                                <span class="text-sm text-slate-400">Sin imagen</span>
                            @endif
                        </div>

                        <div class="mt-5">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <h2 class="text-xl font-semibold text-slate-950">{{ $producto->nombre }}</h2>
                                    <p class="mt-1 text-sm text-slate-500">Vendedor: {{ $producto->vendedor->nombre }} {{ $producto->vendedor->apellidos }}</p>
                                </div>
                                <span class="text-base font-semibold text-slate-950">${{ number_format((float) $producto->precio, 2) }}</span>
                            </div>

                            <p class="mt-4 text-sm leading-7 text-slate-600">{{ \Illuminate\Support\Str::limit($producto->descripcion, 120) }}</p>

                            <div class="mt-4 flex flex-wrap gap-2">
                                @foreach ($producto->categorias as $categoria)
                                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-600">{{ $categoria->nombre }}</span>
                                @endforeach
                            </div>

                            <div class="mt-5 flex items-center justify-between gap-4 text-sm text-slate-500">
                                <span>{{ $producto->existencia }} disponibles</span>
                                <a href="{{ route('productos.show', $producto) }}" class="font-medium text-raph-green-dark transition hover:text-raph-green">Ver detalle</a>
                            </div>

                            @can('update', $producto)
                                <div class="mt-5 flex gap-4 border-t border-slate-200/70 pt-4 text-sm font-medium">
                                    <a href="{{ route('productos.edit', $producto) }}" class="text-raph-green-dark transition hover:text-raph-green">Editar</a>
                                    <form method="POST" action="{{ route('productos.destroy', $producto) }}" onsubmit="return confirm('Se eliminara este producto.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-600 transition hover:text-rose-700">Eliminar</button>
                                    </form>
                                </div>
                            @endcan
                        </div>
                    </article>
                @empty
                    <div class="glass-card p-8 text-sm text-slate-500">Aun no hay productos registrados.</div>
                @endforelse
            </section>

            <div>
                {{ $productos->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
