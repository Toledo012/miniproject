<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Carrito</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @if (session('status'))
                <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-md">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                @if ($items->isEmpty())
                    <p class="text-gray-600">Tu carrito esta vacio.</p>
                    <a href="{{ route('client.products.index') }}" class="text-blue-600 hover:underline mt-2 inline-block">Ir al catalogo</a>
                @else
                    <div class="space-y-4">
                        @foreach ($items as $item)
                            <div class="border rounded-md p-4">
                                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                    <div>
                                        <p class="font-semibold">{{ $item->product->name }}</p>
                                        <p class="text-sm text-gray-600">${{ number_format((float) $item->product->price, 2) }} c/u</p>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <form method="POST" action="{{ route('client.cart.update', $item) }}" class="flex items-center gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <input type="number" name="quantity" min="1" max="99" value="{{ $item->quantity }}" class="border rounded-md px-3 py-2 w-20">
                                            <button type="submit" class="text-blue-600 hover:underline">Actualizar</button>
                                        </form>
                                        <form method="POST" action="{{ route('client.cart.destroy', $item) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Quitar</button>
                                        </form>
                                    </div>
                                </div>
                                <p class="mt-2 text-sm text-gray-700">Subtotal: ${{ number_format(((float) $item->product->price) * $item->quantity, 2) }}</p>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6 border-t pt-4">
                        <p class="text-lg font-semibold">Total: ${{ number_format($total, 2) }}</p>
                        <form method="POST" action="{{ route('client.cart.checkout') }}" class="mt-4">
                            @csrf
                            <button
                                type="submit"
                                style="background:#16a34a;color:#ffffff;border:1px solid #15803d;padding:10px 18px;border-radius:8px;font-weight:700;display:inline-block;"
                            >
                                PAGAR
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
