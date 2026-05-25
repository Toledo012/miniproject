@extends('layouts.app')

@section('title', 'Nueva categoría')

@section('content')
    <div class="card" style="max-width:560px;margin:0 auto">
        <div class="page-header">
            <div>
                <div class="eyebrow">Organización · Alta</div>
                <h1>Nueva categoría</h1>
                <p>Crea una nueva agrupación para tus artículos.</p>
            </div>
        </div>

        @if($errors->any())
            <div class="alert alert-error">
                <div>
                    @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
                </div>
            </div>
        @endif

        <form action="{{ route('categorias.store') }}" method="POST">
            @csrf
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required maxlength="255" autofocus>

            <div class="row" style="margin-top:1rem">
                <button type="submit">Crear categoría</button>
                <a class="btn btn-secondary" href="{{ route('categorias.index') }}">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
