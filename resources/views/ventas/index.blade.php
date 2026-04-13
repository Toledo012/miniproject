<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-raph-green">Ventas</p>
                <h1 class="mt-2 text-3xl font-semibold tracking-tight text-slate-950">Registro comercial</h1>
            </div>
            <a href="{{ route('ventas.create') }}" class="raph-button-primary">Registrar venta</a>
        </div>
    </x-slot>

    <div class="page-section">
        <div class="mx-auto max-w-7xl space-y-6">
            @if (session('status'))
                <div class="glass-card p-4 text-sm text-slate-600">{{ session('status') }}</div>
            @endif

            <div class="glass-card overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-left">
                        <thead class="border-b border-slate-200/70 text-xs uppercase tracking-[0.24em] text-slate-500">
                            <tr>
                                <th class="px-6 py-4">Producto</th>
                                <th class="px-6 py-4">Cliente</th>
                                <th class="px-6 py-4">Vendedor</th>
                                <th class="px-6 py-4">Fecha</th>
                                <th class="px-6 py-4">Total</th>
                                <th class="px-6 py-4 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200/70 text-sm text-slate-700">
                            @forelse ($ventas as $venta)
                                <tr>
                                    <td class="px-6 py-4 font-medium text-slate-900">{{ $venta->producto->nombre }}</td>
                                    <td class="px-6 py-4">{{ $venta->cliente->nombre }} {{ $venta->cliente->apellidos }}</td>
                                    <td class="px-6 py-4">{{ $venta->vendedor->nombre }} {{ $venta->vendedor->apellidos }}</td>
                                    <td class="px-6 py-4">{{ $venta->fecha->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4">${{ number_format((float) $venta->total, 2) }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-end gap-3 text-sm font-medium">
                                            <a href="{{ route('ventas.show', $venta) }}" class="text-raph-green-dark transition hover:text-raph-green">Ver</a>
                                            @can('update', $venta)
                                                <a href="{{ route('ventas.edit', $venta) }}" class="text-slate-600 transition hover:text-slate-900">Editar</a>
                                            @endcan
                                            @can('delete', $venta)
                                                <form method="POST" action="{{ route('ventas.destroy', $venta) }}" onsubmit="return confirm('Se eliminara esta venta.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-rose-600 transition hover:text-rose-700">Eliminar</button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-slate-500">Aun no hay ventas registradas.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div>
                {{ $ventas->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
