@extends('layouts.app')

@section('title', 'Productos')

@php
    $u = auth()->user();
    $titulo = $u?->esVendedor() ? 'Mis artículos' : ($u?->esComprador() ? 'Catálogo' : 'Productos');
    $eyebrow = $u?->esVendedor() ? 'Mi inventario' : 'Inventario';
@endphp

@section('content')
    <div class="card">
        <div class="page-header">
            <div>
                <div class="eyebrow">{{ $eyebrow }}</div>
                <h1>{{ $titulo }}</h1>
                <p>Gestiona y explora todos los artículos disponibles.</p>
            </div>
            @can('create', App\Models\Producto::class)
                <a class="btn" href="{{ route('productos.create') }}">+ Nuevo artículo</a>
            @endcan
        </div>

        @if($productos->isEmpty())
            <p class="muted" style="padding:2rem 0;text-align:center">No hay productos registrados.</p>
        @else
            <div class="grid-cards">
                @foreach($productos as $producto)
                    <div class="product-card">
                        @if($producto->fotos->isNotEmpty())
                            <img class="ph-img" src="{{ asset(Storage::url($producto->fotos->first()->ruta)) }}" alt="{{ $producto->nombre }}">
                        @else
                            <div class="ph-empty">Sin imagen</div>
                        @endif
                        <div class="body">
                            <div class="name">{{ $producto->nombre }}</div>
                            <div class="price">{{ number_format($producto->precio, 2) }}</div>
                            <div class="meta">Stock: <strong style="color:var(--ink)">{{ $producto->stock }}</strong></div>
                            <div class="cats">
                                @foreach($producto->categorias as $cat)
                                    <span class="badge badge-soft">{{ $cat->nombre }}</span>
                                @endforeach
                            </div>
                            <div class="actions">
                                <a class="btn btn-secondary btn-sm" href="{{ route('productos.show', $producto) }}">Ver</a>
                                @can('update', $producto)
                                    <a class="btn btn-sm" href="{{ route('productos.edit', $producto) }}">Editar</a>
                                @endcan
                                @can('delete', $producto)
                                    <form class="inline" action="{{ route('productos.destroy', $producto) }}" method="POST" onsubmit="return confirm('¿Eliminar artículo?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn-danger btn-sm">Eliminar</button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div>{{ $productos->links() }}</div>
        @endif
    </div>
@endsection
