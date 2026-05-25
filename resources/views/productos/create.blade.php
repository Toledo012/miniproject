@extends('layouts.app')

@section('title', 'Nuevo artículo')

@section('content')
    <div class="card" style="max-width:760px;margin:0 auto">
        <div class="page-header">
            <div>
                <div class="eyebrow">Inventario · Alta</div>
                <h1>Nuevo artículo</h1>
                <p>Completa los datos para publicarlo.</p>
            </div>
        </div>

        @if($errors->any())
            <div class="alert alert-error">
                <div>
                    @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
                </div>
            </div>
        @endif

        <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required maxlength="255">

            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" rows="4" required>{{ old('descripcion') }}</textarea>

            @if(auth()->user()->esAdmin() && $vendedores->isNotEmpty())
                <label for="vendedor_id">Vendedor</label>
                <select id="vendedor_id" name="vendedor_id" required>
                    <option value="">— Selecciona un vendedor —</option>
                    @foreach($vendedores as $vendedor)
                        <option value="{{ $vendedor->id }}" @selected(old('vendedor_id') == $vendedor->id)>
                            {{ $vendedor->nombre }}
                        </option>
                    @endforeach
                </select>
            @endif

            <div class="form-row">
                <div>
                    <label for="precio">Precio</label>
                    <input type="number" id="precio" name="precio" step="0.01" min="0" value="{{ old('precio') }}" required>
                </div>
                <div>
                    <label for="stock">Stock</label>
                    <input type="number" id="stock" name="stock" min="0" value="{{ old('stock', 0) }}" required>
                </div>
            </div>

            <label>Categorías</label>
            <div class="chip-group">
                @forelse($categorias as $categoria)
                    <label class="chip">
                        <input type="checkbox" name="categorias[]" value="{{ $categoria->id }}" @checked(in_array($categoria->id, old('categorias', [])))>
                        {{ $categoria->nombre }}
                    </label>
                @empty
                    <span class="muted">No hay categorías. Crea al menos una primero.</span>
                @endforelse
            </div>

            <label for="fotos">Fotos <small>(jpg, jpeg, png, webp · máx 2MB)</small></label>
            <input type="file" id="fotos" name="fotos[]" multiple accept="image/*">

            <div class="row" style="margin-top:1.25rem">
                <button type="submit">Crear artículo</button>
                <a class="btn btn-secondary" href="{{ route('productos.index') }}">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
