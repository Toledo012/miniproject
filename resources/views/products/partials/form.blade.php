<div>
    <label class="block text-sm font-medium mb-1" for="name">Nombre</label>
    <input class="border rounded-md px-3 py-2 w-full" id="name" name="name" type="text" value="{{ old('name', $product?->name) }}" required>
    @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium mb-1" for="description">Descripcion</label>
    <textarea class="border rounded-md px-3 py-2 w-full" id="description" name="description" rows="4">{{ old('description', $product?->description) }}</textarea>
    @error('description') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium mb-1" for="price">Precio</label>
    <input class="border rounded-md px-3 py-2 w-full" id="price" name="price" type="number" min="0" step="0.01" value="{{ old('price', $product?->price) }}" required>
    @error('price') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium mb-1" for="stock">Existencia</label>
    <input class="border rounded-md px-3 py-2 w-full" id="stock" name="stock" type="number" min="0" step="1" value="{{ old('stock', $product?->stock) }}" required>
    @error('stock') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium mb-1" for="image">Imagen</label>
    <input class="border rounded-md px-3 py-2 w-full" id="image" name="image" type="file" accept="image/*">
    @error('image') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    @if ($product?->image_url)
        <img src="{{ $product->image_url }}" alt="Imagen actual" style="margin-top: 12px; width: 96px; height: 96px; object-fit: cover; border-radius: 6px; display: block;">
    @endif
</div>

<div class="flex items-center gap-2">
    <input id="is_active" name="is_active" type="checkbox" value="1" @checked(old('is_active', $product?->is_active ?? true))>
    <label for="is_active">Producto activo</label>
</div>
