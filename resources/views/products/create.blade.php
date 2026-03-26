<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Crear producto</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('inventory.products.store') }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @include('products.partials.form', ['product' => null])
                    <div style="display: flex; gap: 10px; align-items: center; margin-top: 12px;">
                        <button type="submit" style="background: #16a34a; color: #ffffff; padding: 10px 16px; border-radius: 6px; border: 0; font-weight: 700; cursor: pointer;">
                            Guardar producto
                        </button>
                        <a href="{{ route('inventory.products.index') }}" style="display: inline-block; background: #e5e7eb; color: #111827; padding: 10px 16px; border-radius: 6px; text-decoration: none; font-weight: 600;">
                            Volver
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
