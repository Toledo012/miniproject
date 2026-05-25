@extends('layouts.app')

@section('title', 'Catálogo')

@section('content')
    <div class="card" style="background:linear-gradient(135deg,var(--ink) 0%,var(--carbon) 100%);color:#f7f3ec;position:relative;overflow:hidden;border:0;padding:3rem 2.5rem">
        <div style="position:absolute;top:-100px;right:-100px;width:300px;height:300px;border-radius:50%;background:radial-gradient(circle,rgba(201,168,118,.18),transparent 70%);pointer-events:none"></div>
        <div style="position:relative;z-index:1;max-width:680px">
            <div style="font-size:.72rem;letter-spacing:.3em;text-transform:uppercase;color:var(--champagne);font-weight:600;margin-bottom:.5rem">
                Catálogo
            </div>
            <h1 style="color:#f7f3ec;font-size:clamp(2rem,3.5vw,2.85rem);margin-bottom:.75rem">
                Explora la colección
            </h1>
            <p style="color:#a8a39a;font-size:1.05rem;line-height:1.7;margin:0">
                Una selección cuidada de artículos para descubrir, comparar y comprar con confianza.
            </p>
            @guest
                <div style="margin-top:1.5rem;display:flex;gap:.6rem;flex-wrap:wrap">
                    <a class="btn-nav-cta" style="background:var(--champagne);color:var(--ink);padding:.7rem 1.3rem;border-radius:8px;font-weight:600;text-decoration:none;font-size:.9rem" href="{{ route('register.form') }}">Regístrate</a>
                    <a style="background:transparent;color:#f7f3ec;padding:.7rem 1.3rem;border-radius:8px;font-weight:500;text-decoration:none;font-size:.9rem;border:1px solid rgba(255,255,255,.2)" href="{{ route('login') }}">Iniciar sesión</a>
                </div>
            @endguest
        </div>
    </div>

    <div class="card">
        <form method="GET" action="{{ route('catalogo') }}" class="filter-bar">
            <div>
                <label for="categoria">Filtrar por categoría</label>
                <select id="categoria" name="categoria" onchange="this.form.submit()">
                    <option value="">Todas las categorías</option>
                    @foreach($categorias as $cat)
                        <option value="{{ $cat->id }}" @selected($categoriaId === $cat->id)>{{ $cat->nombre }}</option>
                    @endforeach
                </select>
            </div>
            @if($categoriaId)
                <div><a class="btn btn-secondary" href="{{ route('catalogo') }}">Limpiar</a></div>
            @endif
        </form>
    </div>

    @if($productos->isEmpty())
        <div class="card"><p class="muted" style="padding:2rem 0;text-align:center">No hay artículos disponibles.</p></div>
    @else
        <div class="card">
            <div class="grid-cards">
                @foreach($productos as $producto)
                    @php
                        $u = auth()->user();
                        $puedeComprar = $u && $u->esComprador() && $u->id !== $producto->vendedor_id && $producto->stock > 0;
                    @endphp
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
                            @if($producto->vendedor)
                                <div class="meta">por <em>{{ $producto->vendedor->nombre }}</em></div>
                            @endif
                            <div class="cats">
                                @foreach($producto->categorias as $cat)
                                    <span class="badge badge-soft">{{ $cat->nombre }}</span>
                                @endforeach
                            </div>
                            <div class="actions">
                                @guest
                                    <a class="btn btn-block btn-sm" href="{{ route('register.form') }}">Regístrate para comprar</a>
                                @else
                                    @if($puedeComprar)
                                        <a class="btn btn-block btn-sm" href="{{ route('ventas.create', ['producto_id' => $producto->id]) }}">Comprar</a>
                                    @elseif($u->esComprador() && $u->id === $producto->vendedor_id)
                                        <span class="muted" style="font-size:.78rem">Tu propio artículo</span>
                                    @elseif($u->esComprador() && $producto->stock === 0)
                                        <span class="badge badge-rechazada">Sin stock</span>
                                    @else
                                        <span class="muted" style="font-size:.78rem">Solo compradores pueden comprar</span>
                                    @endif
                                @endguest
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div>{{ $productos->links() }}</div>
        </div>
    @endif
@endsection
