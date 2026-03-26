<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-raph-green">RAPH</p>
                <h1 class="text-3xl font-semibold tracking-tight text-slate-950">Resumen general</h1>
                <p class="max-w-2xl text-sm text-slate-600">Una vista limpia del negocio, el inventario y la actividad reciente.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('manager.users.index') }}" class="raph-button-primary">Gestionar usuarios</a>
                <a href="{{ route('manager.content.edit') }}" class="raph-button-secondary">Editar contenido</a>
            </div>
        </div>
    </x-slot>

    <div class="page-section">
        <div class="mx-auto max-w-7xl space-y-6">
            <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                <article class="glass-card p-6"><p class="text-sm text-slate-500">Usuarios totales</p><p class="mt-3 text-4xl font-semibold text-slate-950">{{ $totalUsers }}</p></article>
                <article class="glass-card p-6"><p class="text-sm text-slate-500">Clientes</p><p class="mt-3 text-4xl font-semibold text-slate-950">{{ $totalClients }}</p></article>
                <article class="glass-card p-6"><p class="text-sm text-slate-500">Empleados</p><p class="mt-3 text-4xl font-semibold text-slate-950">{{ $totalEmployees }}</p></article>
                <article class="glass-card p-6"><p class="text-sm text-slate-500">Productos</p><p class="mt-3 text-4xl font-semibold text-slate-950">{{ $totalProducts }}</p></article>
                <article class="glass-card p-6"><p class="text-sm text-slate-500">Stock bajo</p><p class="mt-3 text-4xl font-semibold text-slate-950">{{ $lowStockProducts }}</p></article>
                <article class="glass-card p-6"><p class="text-sm text-slate-500">Pedidos pendientes</p><p class="mt-3 text-4xl font-semibold text-slate-950">{{ $pendingOrders }}</p></article>
                <article class="glass-card p-6"><p class="text-sm text-slate-500">Pedidos entregados</p><p class="mt-3 text-4xl font-semibold text-slate-950">{{ $deliveredOrders }}</p></article>
                <article class="glass-card p-6"><p class="text-sm text-slate-500">Ventas de hoy</p><p class="mt-3 text-4xl font-semibold text-slate-950">${{ number_format($todaySales, 2) }}</p></article>
            </section>

            <section class="grid gap-6 xl:grid-cols-2">
                <div class="glass-card p-6 sm:p-8">
                    <div class="flex items-end justify-between gap-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-raph-green">Inventario</p>
                            <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950">Ultimos productos</h2>
                        </div>
                        <a href="{{ route('inventory.products.index') }}" class="text-sm font-medium text-raph-green-dark transition hover:text-raph-green">Ver inventario</a>
                    </div>
                    <div class="mt-6 space-y-4">
                        @forelse ($latestProducts as $product)
                            <article class="flex items-center gap-4 rounded-[26px] border border-white/80 bg-white/85 p-4 shadow-sm">
                                <div class="flex h-20 w-20 items-center justify-center overflow-hidden rounded-[22px] bg-slate-100">
                                    @if ($product->image_url)
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                                    @else
                                        <span class="text-xs text-slate-400">Sin imagen</span>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <p class="font-semibold text-slate-900">{{ $product->name }}</p>
                                    <p class="mt-1 text-sm text-slate-500">${{ number_format((float) $product->price, 2) }} · Stock {{ $product->stock }}</p>
                                    <p class="mt-1 text-xs uppercase tracking-[0.2em] {{ $product->is_active ? 'text-emerald-600' : 'text-slate-400' }}">{{ $product->is_active ? 'Activo' : 'Inactivo' }}</p>
                                </div>
                            </article>
                        @empty
                            <p class="text-sm text-slate-500">Aun no hay productos registrados.</p>
                        @endforelse
                    </div>
                </div>

                <div class="glass-card p-6 sm:p-8">
                    <div class="flex items-end justify-between gap-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-raph-green">Pedidos</p>
                            <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950">Ultimos pedidos</h2>
                        </div>
                        <a href="{{ route('employee.purchase-requests.index') }}" class="text-sm font-medium text-raph-green-dark transition hover:text-raph-green">Ver solicitudes</a>
                    </div>
                    <div class="mt-6 overflow-hidden rounded-[28px] border border-white/80 bg-white/75">
                        <table class="min-w-full text-left text-sm">
                            <thead class="bg-white/90 text-xs uppercase tracking-[0.22em] text-slate-500">
                                <tr>
                                    <th class="px-5 py-4 font-medium">Folio</th>
                                    <th class="px-5 py-4 font-medium">Cliente</th>
                                    <th class="px-5 py-4 font-medium">Estado</th>
                                    <th class="px-5 py-4 font-medium">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200/70">
                                @forelse ($latestOrders as $order)
                                    <tr class="bg-white/60 text-slate-700">
                                        <td class="px-5 py-4 font-semibold text-slate-900">#{{ $order->id }}</td>
                                        <td class="px-5 py-4">{{ $order->user?->name ?? 'Usuario eliminado' }}</td>
                                        <td class="px-5 py-4">{{ ucfirst($order->status) }}</td>
                                        <td class="px-5 py-4">${{ number_format((float) $order->total, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-5 py-8 text-center text-slate-500">Sin pedidos registrados todavia.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
