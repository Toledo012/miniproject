<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-raph-green">Ventas</p>
            <h1 class="mt-2 text-3xl font-semibold tracking-tight text-slate-950">Editar venta</h1>
        </div>
    </x-slot>

    <div class="page-section">
        <div class="mx-auto max-w-5xl">
            <div class="glass-card p-6 sm:p-8">
                <form method="POST" action="{{ route('ventas.update', $venta) }}" class="space-y-6" x-data="{
                    syncVentaMeta() {
                        const selected = this.$refs.producto.options[this.$refs.producto.selectedIndex];
                        this.$refs.vendedorId.value = selected?.dataset.vendedorId ?? '';
                        this.$refs.vendedorNombre.value = selected?.dataset.vendedor ?? '';
                    }
                }" x-init="syncVentaMeta()">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="producto_id" value="Producto" />
                        <select id="producto_id" name="producto_id" x-ref="producto" @change="syncVentaMeta()" class="mt-2 block w-full rounded-2xl border-white/80 bg-white/80">
                            @foreach ($productos as $producto)
                                <option value="{{ $producto->id }}" data-vendedor-id="{{ $producto->usuario_id }}" data-vendedor="{{ $producto->vendedor->nombre }} {{ $producto->vendedor->apellidos }}" @selected((string) old('producto_id', $venta->producto_id) === (string) $producto->id)>
                                    {{ $producto->nombre }} | ${{ number_format((float) $producto->precio, 2) }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('producto_id')" />
                    </div>

                    <div class="grid gap-6 sm:grid-cols-2">
                        <div>
                            <x-input-label for="cliente_id" value="Cliente" />
                            <select id="cliente_id" name="cliente_id" class="mt-2 block w-full rounded-2xl border-white/80 bg-white/80">
                                @foreach ($clientes as $cliente)
                                    <option value="{{ $cliente->id }}" @selected((string) old('cliente_id', $venta->cliente_id) === (string) $cliente->id)>
                                        {{ $cliente->nombre }} {{ $cliente->apellidos }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('cliente_id')" />
                        </div>
                        <div>
                            <input type="hidden" id="vendedor_id" name="vendedor_id" x-ref="vendedorId" value="{{ old('vendedor_id', $venta->vendedor_id) }}">
                            <x-input-label for="vendedor_nombre" value="Vendedor" />
                            <x-text-input id="vendedor_nombre" x-ref="vendedorNombre" type="text" class="mt-2 block w-full rounded-2xl border-white/80 bg-white/80" readonly />
                            <x-input-error class="mt-2" :messages="$errors->get('vendedor_id')" />
                        </div>
                    </div>

                    <div class="grid gap-6 sm:grid-cols-2">
                        <div>
                            <x-input-label for="fecha" value="Fecha" />
                            <x-text-input id="fecha" name="fecha" type="date" class="mt-2 block w-full rounded-2xl border-white/80 bg-white/80" :value="old('fecha', $venta->fecha->format('Y-m-d'))" required />
                            <x-input-error class="mt-2" :messages="$errors->get('fecha')" />
                        </div>
                        <div>
                            <x-input-label for="total" value="Total" />
                            <x-text-input id="total" name="total" type="number" step="0.01" min="0" class="mt-2 block w-full rounded-2xl border-white/80 bg-white/80" :value="old('total', $venta->total)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('total')" />
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-3 border-t border-slate-200/70 pt-6">
                        <button type="submit" class="raph-button-primary">Guardar cambios</button>
                        <a href="{{ route('ventas.index') }}" class="raph-button-secondary">Volver</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
