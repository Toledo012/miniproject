<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Panel de Empleado</h2>
    </x-slot>

    <div class="py-8" style="padding-top: 28px;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="display: grid; gap: 16px;">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 8px;">Panel Operativo</h3>
                <p style="color: #4b5563;">Gestion diaria de inventario y seguimiento de pedidos.</p>
                <div style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 14px;">
                    <a href="{{ route('inventory.products.index') }}" style="display: inline-block; background: #2563eb; color: #ffffff; padding: 10px 14px; border-radius: 6px; text-decoration: none; font-weight: 600;">Gestionar inventario</a>
                    <a href="{{ route('inventory.products.create') }}" style="display: inline-block; background: #16a34a; color: #ffffff; padding: 10px 14px; border-radius: 6px; text-decoration: none; font-weight: 600;">Agregar producto</a>
                    <a href="{{ route('employee.purchase-requests.index') }}" style="display: inline-block; background: #7c3aed; color: #ffffff; padding: 10px 14px; border-radius: 6px; text-decoration: none; font-weight: 600;">Revisar solicitudes</a>
                </div>
            </div>

            <div style="display: grid; gap: 12px; grid-template-columns: repeat(1, minmax(0, 1fr));" class="employee-stats-grid">
                <div class="bg-white shadow-sm sm:rounded-lg p-6" style="border-left: 4px solid #2563eb;">
                    <p style="font-size: 13px; color: #6b7280;">Productos totales</p>
                    <p style="font-size: 28px; font-weight: 700;">{{ $totalProducts }}</p>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-6" style="border-left: 4px solid #0891b2;">
                    <p style="font-size: 13px; color: #6b7280;">Productos activos</p>
                    <p style="font-size: 28px; font-weight: 700;">{{ $activeProducts }}</p>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-6" style="border-left: 4px solid #ca8a04;">
                    <p style="font-size: 13px; color: #6b7280;">Existencia baja (&lt;10)</p>
                    <p style="font-size: 28px; font-weight: 700;">{{ $lowStockProducts }}</p>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-6" style="border-left: 4px solid #ea580c;">
                    <p style="font-size: 13px; color: #6b7280;">Pedidos pendientes</p>
                    <p style="font-size: 28px; font-weight: 700;">{{ $pendingOrders }}</p>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-6" style="border-left: 4px solid #15803d;">
                    <p style="font-size: 13px; color: #6b7280;">Pedidos entregados</p>
                    <p style="font-size: 28px; font-weight: 700;">{{ $deliveredOrders }}</p>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-6" style="border-left: 4px solid #0f766e;">
                    <p style="font-size: 13px; color: #6b7280;">Pedidos de hoy</p>
                    <p style="font-size: 28px; font-weight: 700;">{{ $todayOrders }}</p>
                </div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 10px;">Pendientes recientes</h3>
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; border: 1px solid #d1d5db;">
                        <thead>
                            <tr>
                                <th style="padding: 10px; border: 1px solid #d1d5db; text-align: left;">Pedido</th>
                                <th style="padding: 10px; border: 1px solid #d1d5db; text-align: left;">Cliente</th>
                                <th style="padding: 10px; border: 1px solid #d1d5db; text-align: left;">Total</th>
                                <th style="padding: 10px; border: 1px solid #d1d5db; text-align: left;">Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($latestPendingOrders as $order)
                                <tr>
                                    <td style="padding: 10px; border: 1px solid #d1d5db;">#{{ $order->id }}</td>
                                    <td style="padding: 10px; border: 1px solid #d1d5db;">{{ $order->user?->name ?? 'Usuario eliminado' }}</td>
                                    <td style="padding: 10px; border: 1px solid #d1d5db;">${{ number_format((float) $order->total, 2) }}</td>
                                    <td style="padding: 10px; border: 1px solid #d1d5db;">{{ $order->created_at?->format('d/m/Y H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" style="padding: 12px; border: 1px solid #d1d5db; color: #4b5563;">No hay pedidos pendientes por ahora.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <style>
                @media (min-width: 640px) {
                    .employee-stats-grid {
                        grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
                    }
                }
                @media (min-width: 1100px) {
                    .employee-stats-grid {
                        grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
                    }
                }
            </style>
        </div>
    </div>
</x-app-layout>
