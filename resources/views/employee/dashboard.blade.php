<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-raph-green">RAPH</p>
                <h1 class="text-3xl font-semibold tracking-tight text-slate-950">Operaciones</h1>
                <p class="max-w-2xl text-sm text-slate-600">Inventario, seguimiento y trabajo diario en una vista directa y ordenada.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('inventory.products.index') }}" class="raph-button-primary">Gestionar inventario</a>
                <a href="{{ route('employee.purchase-requests.index') }}" class="raph-button-secondary">Revisar solicitudes</a>
            </div>
        </div>
    </x-slot>

    <div class="page-section">
        <div class="mx-auto max-w-7xl space-y-6">
            <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                <article class="glass-card p-6"><p class="text-sm text-slate-500">Productos totales</p><p class="mt-3 text-4xl font-semibold text-slate-950">{{ $totalProducts }}</p></article>
                <article class="glass-card p-6"><p class="text-sm text-slate-500">Productos activos</p><p class="mt-3 text-4xl font-semibold text-slate-950">{{ $activeProducts }}</p></article>
                <article class="glass-card p-6"><p class="text-sm text-slate-500">Stock bajo</p><p class="mt-3 text-4xl font-semibold text-slate-950">{{ $lowStockProducts }}</p></article>
                <article class="glass-card p-6"><p class="text-sm text-slate-500">Pedidos pendientes</p><p class="mt-3 text-4xl font-semibold text-slate-950">{{ $pendingOrders }}</p></article>
                <article class="glass-card p-6"><p class="text-sm text-slate-500">Pedidos entregados</p><p class="mt-3 text-4xl font-semibold text-slate-950">{{ $deliveredOrders }}</p></article>
                <article class="glass-card p-6"><p class="text-sm text-slate-500">Pedidos de hoy</p><p class="mt-3 text-4xl font-semibold text-slate-950">{{ $todayOrders }}</p></article>
            </section>

            <section class="glass-card p-6 sm:p-8">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-raph-green">Pendientes</p>
                        <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950">Solicitudes recientes</h2>
                    </div>
                    <a href="{{ route('inventory.products.create') }}" class="text-sm font-medium text-raph-green-dark transition hover:text-raph-green">Agregar producto</a>
                </div>
                <div class="mt-6 overflow-hidden rounded-[28px] border border-white/80 bg-white/75">
                    <table class="min-w-full text-left text-sm">
                        <thead class="bg-white/90 text-xs uppercase tracking-[0.22em] text-slate-500">
                            <tr>
                                <th class="px-5 py-4 font-medium">Pedido</th>
                                <th class="px-5 py-4 font-medium">Cliente</th>
                                <th class="px-5 py-4 font-medium">Total</th>
                                <th class="px-5 py-4 font-medium">Fecha</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200/70">
                            @forelse ($latestPendingOrders as $order)
                                <tr class="bg-white/60 text-slate-700">
                                    <td class="px-5 py-4 font-semibold text-slate-900">#{{ $order->id }}</td>
                                    <td class="px-5 py-4">{{ $order->user?->name ?? 'Usuario eliminado' }}</td>
                                    <td class="px-5 py-4">${{ number_format((float) $order->total, 2) }}</td>
                                    <td class="px-5 py-4">{{ $order->created_at?->format('d/m/Y H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-5 py-8 text-center text-slate-500">No hay pedidos pendientes por ahora.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
