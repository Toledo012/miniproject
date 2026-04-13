<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-raph-green">Organizacion</p>
            <h1 class="mt-2 text-3xl font-semibold tracking-tight text-slate-950">Editar categoria</h1>
        </div>
    </x-slot>

    <div class="page-section">
        <div class="mx-auto max-w-4xl">
            <div class="glass-card p-6 sm:p-8">
                <form method="POST" action="{{ route('categorias.update', $categoria) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="nombre" value="Nombre" />
                        <x-text-input id="nombre" name="nombre" type="text" class="mt-2 block w-full rounded-2xl border-white/80 bg-white/80" :value="old('nombre', $categoria->nombre)" required />
                        <x-input-error class="mt-2" :messages="$errors->get('nombre')" />
                    </div>

                    <div>
                        <x-input-label for="descripcion" value="Descripcion" />
                        <textarea id="descripcion" name="descripcion" rows="5" class="mt-2 block w-full rounded-2xl border-white/80 bg-white/80">{{ old('descripcion', $categoria->descripcion) }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('descripcion')" />
                    </div>

                    <div class="flex flex-wrap gap-3 border-t border-slate-200/70 pt-6">
                        <button type="submit" class="raph-button-primary">Guardar cambios</button>
                        <a href="{{ route('categorias.index') }}" class="raph-button-secondary">Volver</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
