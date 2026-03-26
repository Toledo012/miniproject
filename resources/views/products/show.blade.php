<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detalle de producto</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6 space-y-2">
                @if ($product->image_url)
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-40 h-40 object-cover rounded-md">
                @endif
                <p><span class="font-semibold">Nombre:</span> {{ $product->name }}</p>
                <p><span class="font-semibold">Slug:</span> {{ $product->slug }}</p>
                <p><span class="font-semibold">Descripcion:</span> {{ $product->description ?: 'Sin descripcion' }}</p>
                <p><span class="font-semibold">Precio:</span> ${{ number_format((float) $product->price, 2) }}</p>
                <p><span class="font-semibold">Existencia:</span> {{ $product->stock }}</p>
                <p><span class="font-semibold">Estado:</span> {{ $product->is_active ? 'Activo' : 'Inactivo' }}</p>
                <div class="pt-3">
                    <a class="text-blue-600 hover:underline" href="{{ route('inventory.products.edit', $product) }}">Editar</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

