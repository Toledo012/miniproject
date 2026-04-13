<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-raph-green">Catalogo</p>
            <h1 class="mt-2 text-3xl font-semibold tracking-tight text-slate-950">Editar producto</h1>
        </div>
    </x-slot>

    <div class="page-section">
        <div class="mx-auto max-w-5xl">
            <div class="glass-card p-6 sm:p-8">
                <form method="POST" action="{{ route('productos.update', $producto) }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="nombre" value="Nombre" />
                        <x-text-input id="nombre" name="nombre" type="text" class="mt-2 block w-full rounded-2xl border-white/80 bg-white/80" :value="old('nombre', $producto->nombre)" required />
                        <x-input-error class="mt-2" :messages="$errors->get('nombre')" />
                    </div>

                    <div>
                        <x-input-label for="descripcion" value="Descripcion" />
                        <textarea id="descripcion" name="descripcion" rows="5" class="mt-2 block w-full rounded-2xl border-white/80 bg-white/80">{{ old('descripcion', $producto->descripcion) }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('descripcion')" />
                    </div>

                    <div class="grid gap-6 sm:grid-cols-2">
                        <div>
                            <x-input-label for="precio" value="Precio" />
                            <x-text-input id="precio" name="precio" type="number" step="0.01" min="0" class="mt-2 block w-full rounded-2xl border-white/80 bg-white/80" :value="old('precio', $producto->precio)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('precio')" />
                        </div>
                        <div>
                            <x-input-label for="existencia" value="Existencia" />
                            <x-text-input id="existencia" name="existencia" type="number" min="0" class="mt-2 block w-full rounded-2xl border-white/80 bg-white/80" :value="old('existencia', $producto->existencia)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('existencia')" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="categoria_ids" value="Categorias" />
                        <select id="categoria_ids" name="categoria_ids[]" multiple class="mt-2 block w-full rounded-2xl border-white/80 bg-white/80">
                            @php($seleccionadas = collect(old('categoria_ids', $producto->categorias->pluck('id')->all())))
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}" @selected($seleccionadas->contains($categoria->id))>{{ $categoria->nombre }}</option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('categoria_ids')" />
                        <x-input-error class="mt-2" :messages="$errors->get('categoria_ids.*')" />
                    </div>

                    <div class="grid gap-6 sm:grid-cols-[0.8fr_1.2fr]">
                        <div>
                            <x-input-label for="imagen" value="Nueva imagen" />
                            <input id="imagen" name="imagen" type="file" class="mt-2 block w-full rounded-2xl border border-white/80 bg-white/80 px-4 py-3 text-sm text-slate-600">
                            <x-input-error class="mt-2" :messages="$errors->get('imagen')" />
                        </div>
                        <div class="rounded-[24px] border border-white/80 bg-white/80 p-4">
                            <p class="text-sm font-medium text-slate-700">Vista actual</p>
                            <div class="mt-3 flex h-40 items-center justify-center overflow-hidden rounded-[20px] bg-slate-100">
                                @if ($producto->imagen_url)
                                    <img src="{{ $producto->imagen_url }}" alt="{{ $producto->nombre }}" class="h-full w-full object-contain">
                                @else
                                    <span class="text-sm text-slate-400">Sin imagen</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-3 border-t border-slate-200/70 pt-6">
                        <button type="submit" class="raph-button-primary">Guardar cambios</button>
                        <a href="{{ route('productos.index') }}" class="raph-button-secondary">Volver</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
