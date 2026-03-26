<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Panel de Gerente</h2>
    </x-slot>

    <div class="py-8" style="padding-top: 28px;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="display: grid; gap: 16px;">
            <div style="display: grid; gap: 12px; grid-template-columns: repeat(1, minmax(0, 1fr));" class="manager-stats-grid">
                <div class="bg-white shadow-sm sm:rounded-lg p-6" style="border-left: 4px solid #1d4ed8;">
                    <p style="font-size: 13px; color: #6b7280;">Usuarios totales</p>
                    <p style="font-size: 28px; font-weight: 700;">{{ $totalUsers }}</p>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-6" style="border-left: 4px solid #0891b2;">
                    <p style="font-size: 13px; color: #6b7280;">Clientes</p>
                    <p style="font-size: 28px; font-weight: 700;">{{ $totalClients }}</p>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-6" style="border-left: 4px solid #7c3aed;">
                    <p style="font-size: 13px; color: #6b7280;">Empleados</p>
                    <p style="font-size: 28px; font-weight: 700;">{{ $totalEmployees }}</p>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-6" style="border-left: 4px solid #16a34a;">
                    <p style="font-size: 13px; color: #6b7280;">Productos</p>
                    <p style="font-size: 28px; font-weight: 700;">{{ $totalProducts }}</p>
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
                    <p style="font-size: 13px; color: #6b7280;">Ventas de hoy</p>
                    <p style="font-size: 28px; font-weight: 700;">${{ number_format($todaySales, 2) }}</p>
                </div>
            </div>
            <style>
                @media (min-width: 640px) {
                    .manager-stats-grid {
                        grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
                    }
                }
                @media (min-width: 1024px) {
                    .manager-stats-grid {
                        grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
                    }
                }
            </style>

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 10px;">Ultimos productos</h3>
                <ul style="display: grid; gap: 10px;">
                    @forelse ($latestProducts as $product)
                        <li style="border: 1px solid #e5e7eb; border-radius: 8px; padding: 10px; display: flex; align-items: center; gap: 12px;">
                            <div style="width: 64px; height: 64px; border-radius: 6px; overflow: hidden; flex-shrink: 0; background: #f3f4f6; display: flex; align-items: center; justify-content: center;">
                                @if ($product->image_url)
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" style="width: 64px; height: 64px; object-fit: cover; display: block;">
                                @else
                                    <span style="font-size: 11px; color: #6b7280;">Sin imagen</span>
                                @endif
                            </div>
                            <div>
                                <p style="font-weight: 600;">{{ $product->name }}</p>
                                <p style="font-size: 14px; color: #4b5563;">${{ number_format((float) $product->price, 2) }} | Existencia: {{ $product->stock }} | {{ $product->is_active ? 'Activo' : 'Inactivo' }}</p>
                            </div>
                        </li>
                    @empty
                        <li style="color: #4b5563;">Aun no hay productos registrados.</li>
                    @endforelse
                </ul>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 10px;">Ultimos pedidos</h3>
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; border: 1px solid #d1d5db;">
                        <thead>
                            <tr>
                                <th style="padding: 10px; border: 1px solid #d1d5db; text-align: left;">Folio</th>
                                <th style="padding: 10px; border: 1px solid #d1d5db; text-align: left;">Cliente</th>
                                <th style="padding: 10px; border: 1px solid #d1d5db; text-align: left;">Estado</th>
                                <th style="padding: 10px; border: 1px solid #d1d5db; text-align: left;">Total</th>
                                <th style="padding: 10px; border: 1px solid #d1d5db; text-align: left;">Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($latestOrders as $order)
                                <tr>
                                    <td style="padding: 10px; border: 1px solid #d1d5db;">#{{ $order->id }}</td>
                                    <td style="padding: 10px; border: 1px solid #d1d5db;">{{ $order->user?->name ?? 'Usuario eliminado' }}</td>
                                    <td style="padding: 10px; border: 1px solid #d1d5db;">{{ ucfirst($order->status) }}</td>
                                    <td style="padding: 10px; border: 1px solid #d1d5db;">${{ number_format((float) $order->total, 2) }}</td>
                                    <td style="padding: 10px; border: 1px solid #d1d5db;">{{ $order->created_at?->format('d/m/Y H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="padding: 12px; border: 1px solid #d1d5db; color: #4b5563;">Sin pedidos registrados todavia.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
