@extends('layouts.app')

@section('title', $categoria->nombre)

@section('content')
    <div class="card">
        <div class="page-header">
            <div>
                <div class="eyebrow">Categoría</div>
                <h1>{{ $categoria->nombre }}</h1>
                <p>Slug: <code>{{ $categoria->slug }}</code></p>
            </div>
            <a class="btn btn-ghost" href="{{ route('categorias.index') }}">← Volver</a>
        </div>

        <h2>Artículos en esta categoría</h2>
        @if($categoria->productos->isEmpty())
            <p class="muted">No hay artículos asociados.</p>
        @else
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr><th>Artículo</th><th style="text-align:right">Precio</th></tr>
                    </thead>
                    <tbody>
                        @foreach($categoria->productos as $producto)
                            <tr>
                                <td><strong>{{ $producto->nombre }}</strong></td>
                                <td style="text-align:right">${{ number_format($producto->precio, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
