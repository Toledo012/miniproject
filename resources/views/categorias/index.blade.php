<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-raph-green">Organizacion</p>
                <h1 class="mt-2 text-3xl font-semibold tracking-tight text-slate-950">Categorias</h1>
            </div>
            @can('create', \App\Models\Categoria::class)
                <a href="{{ route('categorias.create') }}" class="raph-button-primary">Nueva categoria</a>
            @endcan
        </div>
    </x-slot>

    <div class="page-section">
        <div class="mx-auto max-w-7xl space-y-6">
            @if (session('status'))
                <div class="glass-card p-4 text-sm text-slate-600">{{ session('status') }}</div>
            @endif

            <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                @forelse ($categorias as $categoria)
                    <article class="glass-card p-6">
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-raph-green">{{ $categoria->productos_count }} productos</p>
                        <h2 class="mt-3 text-2xl font-semibold text-slate-950">{{ $categoria->nombre }}</h2>
                        <p class="mt-4 text-sm leading-7 text-slate-600">{{ $categoria->descripcion }}</p>

                        <div class="mt-6 flex flex-wrap gap-4 text-sm font-medium">
                            <a href="{{ route('categorias.show', $categoria) }}" class="text-raph-green-dark transition hover:text-raph-green">Ver detalle</a>
                            @can('update', $categoria)
                                <a href="{{ route('categorias.edit', $categoria) }}" class="text-slate-600 transition hover:text-slate-900">Editar</a>
                            @endcan
                            @can('delete', $categoria)
                                <form method="POST" action="{{ route('categorias.destroy', $categoria) }}" onsubmit="return confirm('Se eliminara esta categoria.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 transition hover:text-rose-700">Eliminar</button>
                                </form>
                            @endcan
                        </div>
                    </article>
                @empty
                    <div class="glass-card p-8 text-sm text-slate-500">Aun no hay categorias registradas.</div>
                @endforelse
            </div>

            <div>
                {{ $categorias->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
