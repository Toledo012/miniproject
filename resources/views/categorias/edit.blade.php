@extends('layouts.app')

@section('title', 'Editar categoría')

@section('content')
    <div class="card" style="max-width:560px;margin:0 auto">
        <div class="page-header">
            <div>
                <div class="eyebrow">Organización · Edición</div>
                <h1>Editar categoría</h1>
                <p>Actualiza el nombre de <strong>{{ $categoria->nombre }}</strong>.</p>
            </div>
        </div>

        @if($errors->any())
            <div class="alert alert-error">
                <div>
                    @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
                </div>
            </div>
        @endif

        <form action="{{ route('categorias.update', $categoria) }}" method="POST">
            @csrf
            @method('PUT')
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $categoria->nombre) }}" required maxlength="255" autofocus>

            <div class="row" style="margin-top:1rem">
                <button type="submit">Guardar cambios</button>
                <a class="btn btn-secondary" href="{{ route('categorias.index') }}">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
