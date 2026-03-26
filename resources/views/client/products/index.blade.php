<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Catalogo de Productos</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="GET" action="{{ route('client.products.index') }}" class="flex gap-3">
                    <input
                        type="text"
                        name="q"
                        value="{{ $search }}"
                        placeholder="Buscar por nombre o descripcion"
                        class="border rounded-md px-3 py-2 w-full"
                    >
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md">Buscar</button>
                </form>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div style="display: grid; gap: 14px; grid-template-columns: repeat(1, minmax(0, 1fr));" class="client-products-grid">
                    @forelse ($products as $product)
                        <article style="border: 1px solid #d1d5db; border-radius: 8px; padding: 12px; display: flex; flex-direction: column; gap: 10px; min-height: 390px;">
                            <div style="width: 100%; height: 180px; background: #f3f4f6; border-radius: 6px; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                                @if ($product->image_url)
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" style="width: 100%; height: 180px; object-fit: contain; object-position: center; display: block; background: #f3f4f6;">
                                @else
                                    <div style="width: 100%; height: 180px; display: flex; align-items: center; justify-content: center; font-size: 12px; color: #6b7280;">Sin imagen</div>
                                @endif
                            </div>
                            <div>
                                <h3 style="font-size: 18px; font-weight: 700; line-height: 1.3; min-height: 48px;">
                                    <a href="{{ route('client.products.show', $product) }}" style="color: #1d4ed8; text-decoration: none;">
                                        {{ $product->name }}
                                    </a>
                                </h3>
                                <p style="font-size: 14px; color: #4b5563; margin-top: 6px; min-height: 40px;">
                                    {{ \Illuminate\Support\Str::limit($product->description ?: 'Sin descripcion', 95) }}
                                </p>
                            </div>
                            <p style="font-weight: 700;">${{ number_format((float) $product->price, 2) }} | Existencia: {{ $product->stock }}</p>
                            <form method="POST" action="{{ route('client.cart.store', $product) }}" style="margin-top: auto;">
                                @csrf
                                <button type="submit" style="background: #2563eb; color: #ffffff; border: 0; border-radius: 6px; padding: 8px 12px; font-weight: 700; cursor: pointer;">
                                    Agregar al carrito
                                </button>
                            </form>
                        </article>
                    @empty
                        <p class="text-gray-600">No hay productos disponibles para la busqueda actual.</p>
                    @endforelse
                </div>
                <style>
                    @media (min-width: 768px) {
                        .client-products-grid {
                            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
                        }
                    }
                    @media (min-width: 1200px) {
                        .client-products-grid {
                            grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
                        }
                    }
                </style>
                @if ($products->hasPages())
                    <div class="mt-6">
                        <nav class="border rounded-lg overflow-hidden inline-flex bg-white">
                            @if ($products->onFirstPage())
                                <span class="px-4 py-2 text-gray-400 border-r">Anterior</span>
                            @else
                                <a href="{{ $products->previousPageUrl() }}" class="px-4 py-2 border-r hover:bg-gray-50">Anterior</a>
                            @endif

                            @php
                                $current = $products->currentPage();
                                $last = $products->lastPage();
                                $start = max(1, $current - 1);
                                $end = min($last, $current + 1);
                            @endphp

                            @if ($start > 1)
                                <a href="{{ $products->url(1) }}" class="px-4 py-2 border-r hover:bg-gray-50">1</a>
                                @if ($start > 2)
                                    <span class="px-4 py-2 border-r text-gray-500">...</span>
                                @endif
                            @endif

                            @for ($page = $start; $page <= $end; $page++)
                                @if ($page == $current)
                                    <span class="px-4 py-2 border-r bg-gray-100 font-semibold">{{ $page }}</span>
                                @else
                                    <a href="{{ $products->url($page) }}" class="px-4 py-2 border-r hover:bg-gray-50">{{ $page }}</a>
                                @endif
                            @endfor

                            @if ($end < $last)
                                @if ($end < $last - 1)
                                    <span class="px-4 py-2 border-r text-gray-500">...</span>
                                @endif
                                <a href="{{ $products->url($last) }}" class="px-4 py-2 border-r hover:bg-gray-50">{{ $last }}</a>
                            @endif

                            @if ($products->hasMorePages())
                                <a href="{{ $products->nextPageUrl() }}" class="px-4 py-2 hover:bg-gray-50">Siguiente</a>
                            @else
                                <span class="px-4 py-2 text-gray-400">Siguiente</span>
                            @endif
                        </nav>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
