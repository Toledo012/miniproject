<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Solicitudes de Compra</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @if (session('status'))
                <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-md">
                    {{ session('status') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-md">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg p-4">
                <form method="GET" action="{{ route('employee.purchase-requests.index') }}" style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                    <label for="status" style="font-weight: 600;">Filtrar por estatus:</label>
                    <select id="status" name="status" style="border: 1px solid #d1d5db; border-radius: 6px; padding: 8px 10px; min-width: 200px;">
                        <option value="" @selected($selectedStatus === '')>Todos</option>
                        @foreach ($statuses as $value => $label)
                            <option value="{{ $value }}" @selected($selectedStatus === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    <button type="submit" style="background: #2563eb; color: #fff; border: 0; border-radius: 6px; padding: 8px 14px; font-weight: 600; cursor: pointer;">
                        Aplicar
                    </button>
                    @if ($selectedStatus !== '')
                        <a href="{{ route('employee.purchase-requests.index') }}" style="text-decoration: none; color: #374151;">Limpiar</a>
                    @endif
                </form>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                @forelse ($orders as $order)
                    <article class="border rounded-md p-4 mb-4">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                            <div>
                                <h3 class="font-semibold">Pedido #{{ $order->id }} - {{ $order->shipping_name }}</h3>
                                <p class="text-sm text-gray-600">{{ $order->user->email }}</p>
                                <p class="text-sm text-gray-600">
                                    {{ $order->shipping_address }},
                                    {{ $order->shipping_city }},
                                    {{ $order->shipping_state }},
                                    {{ $order->shipping_postal_code }}
                                </p>
                                <p class="text-sm text-gray-600">Telefono: {{ $order->shipping_phone ?: 'N/A' }}</p>
                            </div>
                            <form method="POST" action="{{ route('employee.purchase-requests.status', $order) }}" class="flex items-center gap-2" style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status_filter" value="{{ $selectedStatus }}">
                                <input type="hidden" name="page" value="{{ $orders->currentPage() }}">
                                <label for="order-status-{{ $order->id }}" style="font-size: 13px; color: #4b5563;">Estado:</label>
                                <select id="order-status-{{ $order->id }}" name="status" class="border rounded-md px-3 py-2" style="border: 1px solid #d1d5db; border-radius: 6px; padding: 8px 10px;" onchange="this.form.submit()">
                                    @foreach ($statuses as $value => $label)
                                        <option value="{{ $value }}" @selected($order->status === $value)>{{ $label }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" style="background: #2563eb; color: #ffffff; border: 0; border-radius: 6px; padding: 8px 12px; cursor: pointer; font-weight: 600;">
                                    Guardar estado
                                </button>
                            </form>
                        </div>

                        <div class="mt-4">
                            <p class="font-medium">Productos:</p>
                            <ul class="mt-1 space-y-1">
                                @foreach ($order->items as $item)
                                    <li class="text-sm text-gray-700">
                                        {{ $item->product_name }} x{{ $item->quantity }} - ${{ number_format((float) $item->subtotal, 2) }}
                                    </li>
                                @endforeach
                            </ul>
                            <p class="mt-2 text-sm font-semibold">Total: ${{ number_format((float) $order->total, 2) }}</p>
                        </div>
                    </article>
                @empty
                    <p class="text-gray-600">No hay pedidos registrados.</p>
                @endforelse

                <div>{{ $orders->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
