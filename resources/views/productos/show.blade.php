@extends('layouts.app')

@section('title', $producto->nombre)

@section('content')
    <div class="card">
        <div class="page-header">
            <div>
                <div class="eyebrow">Detalle del artículo</div>
                <h1>{{ $producto->nombre }}</h1>
                @if($producto->vendedor)
                    <p>Publicado por <strong>{{ $producto->vendedor->nombre }}</strong></p>
                @endif
            </div>
            <div class="row">
                @auth
                    @if(auth()->user()->esComprador() && auth()->id() !== $producto->vendedor_id)
                        <a class="btn" href="{{ route('ventas.create', ['producto_id' => $producto->id]) }}">Comprar</a>
                    @endif
                @endauth
                @can('update', $producto)
                    <a class="btn btn-secondary" href="{{ route('productos.edit', $producto) }}">Editar</a>
                @endcan
                <a class="btn btn-ghost" href="{{ route('productos.index') }}">← Volver</a>
            </div>
        </div>

        <div style="display:grid;grid-template-columns:minmax(260px,1.1fr) 1.4fr;gap:2rem;align-items:start">
            <div>
                @if($producto->fotos->isNotEmpty())
                    <div style="display:flex;flex-direction:column;gap:.75rem">
                        @foreach($producto->fotos as $foto)
                            <img src="{{ asset(Storage::url($foto->ruta)) }}" style="width:100%;aspect-ratio:1/1;object-fit:cover;border-radius:12px;border:1px solid var(--line)">
                        @endforeach
                    </div>
                @else
                    <div class="ph-empty" style="border-radius:12px;border:1px solid var(--line)">Sin imágenes</div>
                @endif
            </div>

            <div class="stack">
                <div style="display:flex;align-items:baseline;gap:.75rem">
                    <div style="font-family:'Playfair Display',serif;font-size:2.5rem;font-weight:600;letter-spacing:-.02em">
                        <span style="font-size:1.25rem;color:var(--champagne-dark);font-weight:500">$</span>{{ number_format($producto->precio, 2) }}
                    </div>
                    <div class="muted" style="font-size:.85rem">Stock disponible: <strong style="color:var(--ink)">{{ $producto->stock }}</strong></div>
                </div>

                <div>
                    <div style="font-size:.7rem;letter-spacing:.2em;text-transform:uppercase;color:var(--muted);font-weight:600;margin-bottom:.5rem">
                        Descripción
                    </div>
                    <p style="font-size:1rem;line-height:1.7;color:var(--ink);margin:0">{{ $producto->descripcion }}</p>
                </div>

                @if($producto->categorias->isNotEmpty())
                <div>
                    <div style="font-size:.7rem;letter-spacing:.2em;text-transform:uppercase;color:var(--muted);font-weight:600;margin-bottom:.5rem">
                        Categorías
                    </div>
                    <div class="row">
                        @foreach($producto->categorias as $cat)
                            <span class="badge badge-soft">{{ $cat->nombre }}</span>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection
