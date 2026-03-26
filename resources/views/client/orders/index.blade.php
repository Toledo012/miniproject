<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Mis pedidos</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @if (session('status'))
                <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-md">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                @forelse ($orders as $order)
                    <article class="border rounded-md p-4 mb-4">
                        <div class="flex flex-wrap items-center justify-between gap-2">
                            <h3 class="font-semibold">Pedido #{{ $order->id }}</h3>
                            <span class="text-sm px-2 py-1 rounded {{ $order->status === 'pendiente' ? 'bg-yellow-100 text-yellow-800' : ($order->status === 'entregado' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-700') }}">
                                Estado: {{ $order->status === 'pendiente' ? 'Pendiente' : ($order->status === 'entregado' ? 'Entregado' : ucfirst($order->status)) }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-600 mt-1">Fecha: {{ $order->created_at->format('Y-m-d H:i') }}</p>
                        <p class="text-sm text-gray-600">Total: ${{ number_format((float) $order->total, 2) }}</p>
                        <ul class="mt-3 space-y-1">
                            @foreach ($order->items as $item)
                                <li class="text-sm text-gray-700">
                                    {{ $item->product_name }} x{{ $item->quantity }} - ${{ number_format((float) $item->subtotal, 2) }}
                                </li>
                            @endforeach
                        </ul>
                    </article>
                @empty
                    <p class="text-gray-600">Aun no tienes pedidos.</p>
                @endforelse

                <div>{{ $orders->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
