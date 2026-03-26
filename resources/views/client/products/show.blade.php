<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detalle del Producto</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div style="background: #f3f4f6; border-radius: 6px; overflow: hidden; height: 260px; max-width: 520px; width: 100%; margin: 0 auto; display: flex; align-items: center; justify-content: center;">
                        @if ($product->image_url)
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" style="width: 100%; height: 260px; object-fit: contain; object-position: center; display: block; background: #f3f4f6;">
                        @else
                            <div style="width: 100%; height: 260px; display: flex; align-items: center; justify-content: center; color: #6b7280;">Sin imagen disponible</div>
                        @endif
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold">{{ $product->name }}</h3>
                        <p class="mt-3 text-gray-700 whitespace-pre-line">{{ $product->description ?: 'Sin descripcion' }}</p>
                        <p class="mt-4 text-xl font-semibold">${{ number_format((float) $product->price, 2) }}</p>
                        <p class="text-sm text-gray-600 mt-1">Existencia disponible: {{ $product->stock }}</p>
                        <form method="POST" action="{{ route('client.cart.store', $product) }}" class="mt-5 flex flex-col items-start gap-3">
                            @csrf
                            <input type="number" name="quantity" min="1" max="99" value="1" class="border rounded-md px-3 py-2 w-24">
                            <button type="submit" class="inline-flex items-center bg-red-600 text-white border border-red-700 px-4 py-2 rounded-md shadow hover:bg-red-700">
                                Agregar al carrito
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div>
                <a href="{{ route('client.products.index') }}" class="text-blue-600 hover:underline">Volver al catalogo</a>
            </div>
        </div>
    </div>
</x-app-layout>
