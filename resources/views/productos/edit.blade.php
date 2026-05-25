@extends('layouts.app')

@section('title', 'Editar artículo')

@section('content')
    <div class="card" style="max-width:760px;margin:0 auto">
        <div class="page-header">
            <div>
                <div class="eyebrow">Inventario · Edición</div>
                <h1>Editar artículo</h1>
                <p>Actualiza los datos de <strong>{{ $producto->nombre }}</strong>.</p>
            </div>
        </div>

        @if($errors->any())
            <div class="alert alert-error">
                <div>
                    @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
                </div>
            </div>
        @endif

        <form action="{{ route('productos.update', $producto) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $producto->nombre) }}" required maxlength="255">

            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" rows="4" required>{{ old('descripcion', $producto->descripcion) }}</textarea>

            @if(auth()->user()->esAdmin() && $vendedores->isNotEmpty())
                <label for="vendedor_id">Vendedor</label>
                <select id="vendedor_id" name="vendedor_id" required>
                    @foreach($vendedores as $vendedor)
                        <option value="{{ $vendedor->id }}" @selected(old('vendedor_id', $producto->vendedor_id) == $vendedor->id)>
                            {{ $vendedor->nombre }}
                        </option>
                    @endforeach
                </select>
            @endif

            <div class="form-row">
                <div>
                    <label for="precio">Precio</label>
                    <input type="number" id="precio" name="precio" step="0.01" min="0" value="{{ old('precio', $producto->precio) }}" required>
                </div>
                <div>
                    <label for="stock">Stock</label>
                    <input type="number" id="stock" name="stock" min="0" value="{{ old('stock', $producto->stock) }}" required>
                </div>
            </div>

            @php($idsActuales = old('categorias', $producto->categorias->pluck('id')->all()))
            <label>Categorías</label>
            <div class="chip-group">
                @foreach($categorias as $categoria)
                    <label class="chip">
                        <input type="checkbox" name="categorias[]" value="{{ $categoria->id }}" @checked(in_array($categoria->id, $idsActuales))>
                        {{ $categoria->nombre }}
                    </label>
                @endforeach
            </div>

            @if($producto->fotos->isNotEmpty())
                <label>Fotos actuales <small>(marca para eliminar)</small></label>
                <div style="display:flex;flex-wrap:wrap;gap:.75rem;margin-bottom:1rem">
                    @foreach($producto->fotos as $foto)
                        <label style="text-align:center;background:var(--surface-2);border:1px solid var(--line);padding:.5rem;border-radius:10px">
                            <img src="{{ asset(Storage::url($foto->ruta)) }}" style="width:120px;height:120px;object-fit:cover;border-radius:6px;display:block;margin-bottom:.4rem">
                            <span style="font-size:.78rem;color:var(--muted);display:flex;align-items:center;gap:.35rem;justify-content:center">
                                <input type="checkbox" name="fotos_eliminar[]" value="{{ $foto->id }}" style="width:auto;margin:0;accent-color:var(--bad-ink)"> Eliminar
                            </span>
                        </label>
                    @endforeach
                </div>
            @endif

            <label for="fotos">Agregar nuevas fotos</label>
            <input type="file" id="fotos" name="fotos[]" multiple accept="image/*">

            <div class="row" style="margin-top:1.25rem">
                <button type="submit">Guardar cambios</button>
                <a class="btn btn-secondary" href="{{ route('productos.index') }}">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
