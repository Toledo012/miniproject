<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Inventario de Productos</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                @if (session('status'))
                    <p class="mb-4 text-green-700">{{ session('status') }}</p>
                @endif
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; border: 1px solid #d1d5db;">
                        <thead>
                            <tr>
                                <th style="padding: 10px; border: 1px solid #d1d5db; text-align: left; width: 130px;">Imagen</th>
                                <th style="padding: 10px; border: 1px solid #d1d5db; text-align: left;">Nombre</th>
                                <th style="padding: 10px; border: 1px solid #d1d5db; text-align: left; width: 120px;">Precio</th>
                                <th style="padding: 10px; border: 1px solid #d1d5db; text-align: left; width: 90px;">Existencia</th>
                                <th style="padding: 10px; border: 1px solid #d1d5db; text-align: left; width: 100px;">Estado</th>
                                <th style="padding: 10px; border: 1px solid #d1d5db; text-align: left; width: 180px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td style="padding: 10px; border: 1px solid #d1d5db; vertical-align: middle;">
                                        @if ($product->image_url)
                                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" style="width: 72px; height: 72px; object-fit: cover; border-radius: 6px; display: block;">
                                        @else
                                            <span style="font-size: 12px; color: #6b7280;">Sin imagen</span>
                                        @endif
                                    </td>
                                    <td style="padding: 10px; border: 1px solid #d1d5db; vertical-align: middle;">{{ $product->name }}</td>
                                    <td style="padding: 10px; border: 1px solid #d1d5db; vertical-align: middle;">${{ number_format((float) $product->price, 2) }}</td>
                                    <td style="padding: 10px; border: 1px solid #d1d5db; vertical-align: middle;">{{ $product->stock }}</td>
                                    <td style="padding: 10px; border: 1px solid #d1d5db; vertical-align: middle;">{{ $product->is_active ? 'Activo' : 'Inactivo' }}</td>
                                    <td style="padding: 10px; border: 1px solid #d1d5db; vertical-align: middle; white-space: nowrap;">
                                        <div style="display: flex; align-items: center; gap: 12px;">
                                            <a href="{{ route('inventory.products.show', $product) }}" style="color: #2563eb; text-decoration: none;">Ver</a>
                                            <a href="{{ route('inventory.products.edit', $product) }}" style="color: #2563eb; text-decoration: none;">Editar</a>
                                            <form method="POST" action="{{ route('inventory.products.destroy', $product) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" style="color: #dc2626; background: transparent; border: 0; cursor: pointer;">Eliminar</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if ($products->hasPages())
                    <div style="margin-top: 16px;">
                        <nav style="border: 1px solid #d1d5db; border-radius: 8px; overflow: hidden; display: inline-flex; background: #ffffff;">
                            @if ($products->onFirstPage())
                                <span style="padding: 8px 14px; color: #9ca3af; border-right: 1px solid #d1d5db;">Anterior</span>
                            @else
                                <a href="{{ $products->previousPageUrl() }}" style="padding: 8px 14px; border-right: 1px solid #d1d5db; text-decoration: none; color: #111827;">Anterior</a>
                            @endif

                            @php
                                $current = $products->currentPage();
                                $last = $products->lastPage();
                                $start = max(1, $current - 1);
                                $end = min($last, $current + 1);
                            @endphp

                            @if ($start > 1)
                                <a href="{{ $products->url(1) }}" style="padding: 8px 14px; border-right: 1px solid #d1d5db; text-decoration: none; color: #111827;">1</a>
                                @if ($start > 2)
                                    <span style="padding: 8px 14px; border-right: 1px solid #d1d5db; color: #6b7280;">...</span>
                                @endif
                            @endif

                            @for ($page = $start; $page <= $end; $page++)
                                @if ($page == $current)
                                    <span style="padding: 8px 14px; border-right: 1px solid #d1d5db; background: #f3f4f6; font-weight: 700;">{{ $page }}</span>
                                @else
                                    <a href="{{ $products->url($page) }}" style="padding: 8px 14px; border-right: 1px solid #d1d5db; text-decoration: none; color: #111827;">{{ $page }}</a>
                                @endif
                            @endfor

                            @if ($end < $last)
                                @if ($end < $last - 1)
                                    <span style="padding: 8px 14px; border-right: 1px solid #d1d5db; color: #6b7280;">...</span>
                                @endif
                                <a href="{{ $products->url($last) }}" style="padding: 8px 14px; border-right: 1px solid #d1d5db; text-decoration: none; color: #111827;">{{ $last }}</a>
                            @endif

                            @if ($products->hasMorePages())
                                <a href="{{ $products->nextPageUrl() }}" style="padding: 8px 14px; text-decoration: none; color: #111827;">Siguiente</a>
                            @else
                                <span style="padding: 8px 14px; color: #9ca3af;">Siguiente</span>
                            @endif
                        </nav>
                    </div>
                @endif
                <div style="margin-top: 16px; padding-top: 12px; border-top: 1px solid #e5e7eb;">
                    <a href="{{ route('inventory.products.create') }}" style="display: inline-block; background: #2563eb; color: #ffffff; padding: 10px 16px; border-radius: 6px; text-decoration: none; font-weight: 700;">
                        + Agregar nuevo producto
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
