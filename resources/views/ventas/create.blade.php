<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-raph-green">Ventas</p>
            <h1 class="mt-2 text-3xl font-semibold tracking-tight text-slate-950">Registrar venta</h1>
        </div>
    </x-slot>

    <div class="page-section">
        <div class="mx-auto max-w-5xl">
            <div class="glass-card p-6 sm:p-8">
                <form method="POST" action="{{ route('ventas.store') }}" class="space-y-6" x-data="{
                    syncVentaMeta() {
                        const selected = this.$refs.producto.options[this.$refs.producto.selectedIndex];
                        this.$refs.total.value = selected?.dataset.precio ?? '';
                        if (this.$refs.vendedorNombre) {
                            this.$refs.vendedorNombre.value = selected?.dataset.vendedor ?? '';
                        }
                    }
                }" x-init="syncVentaMeta()">
                    @csrf

                    <div>
                        <x-input-label for="producto_id" value="Producto" />
                        <select id="producto_id" name="producto_id" x-ref="producto" @change="syncVentaMeta()" class="mt-2 block w-full rounded-2xl border-white/80 bg-white/80">
                            @foreach ($productos as $producto)
                                <option value="{{ $producto->id }}" data-precio="{{ number_format((float) $producto->precio, 2, '.', '') }}" data-vendedor="{{ $producto->vendedor->nombre }} {{ $producto->vendedor->apellidos }}" @selected((string) old('producto_id', request('producto')) === (string) $producto->id)>
                                    {{ $producto->nombre }} | ${{ number_format((float) $producto->precio, 2) }} | {{ $producto->vendedor->nombre }} {{ $producto->vendedor->apellidos }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('producto_id')" />
                    </div>

                    @unless (auth()->user()->esCliente())
                        <div>
                            <x-input-label for="cliente_id" value="Cliente" />
                            <select id="cliente_id" name="cliente_id" class="mt-2 block w-full rounded-2xl border-white/80 bg-white/80">
                                <option value="">Seleccionar cliente</option>
                                @foreach ($clientes as $cliente)
                                    <option value="{{ $cliente->id }}" @selected((string) old('cliente_id') === (string) $cliente->id)>
                                        {{ $cliente->nombre }} {{ $cliente->apellidos }} | {{ $cliente->correo }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('cliente_id')" />
                        </div>
                    @endunless

                    <div class="grid gap-6 sm:grid-cols-2">
                        <div>
                            <x-input-label for="vendedor_nombre" value="Vendedor" />
                            <x-text-input id="vendedor_nombre" x-ref="vendedorNombre" type="text" class="mt-2 block w-full rounded-2xl border-white/80 bg-white/80" readonly />
                        </div>
                        <div>
                            <x-input-label for="fecha" value="Fecha" />
                            <x-text-input id="fecha" name="fecha" type="date" class="mt-2 block w-full rounded-2xl border-white/80 bg-white/80" :value="old('fecha', now()->toDateString())" required />
                            <x-input-error class="mt-2" :messages="$errors->get('fecha')" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="total" value="Total" />
                        <x-text-input id="total" name="total" x-ref="total" type="number" step="0.01" min="0" class="mt-2 block w-full rounded-2xl border-white/80 bg-white/80" :value="old('total')" required readonly />
                        <p class="mt-2 text-sm text-slate-500">Se actualiza automaticamente segun el producto seleccionado.</p>
                        <x-input-error class="mt-2" :messages="$errors->get('total')" />
                    </div>

                    <div class="flex flex-wrap gap-3 border-t border-slate-200/70 pt-6">
                        <button type="submit" class="raph-button-primary">Guardar venta</button>
                        <a href="{{ route('ventas.index') }}" class="raph-button-secondary">Volver</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
