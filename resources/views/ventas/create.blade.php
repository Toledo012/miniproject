@extends('layouts.app')

@section('title', 'Nueva compra')

@section('content')
    <div class="card" style="max-width:640px;margin:0 auto">
        <div class="page-header">
            <div>
                <div class="eyebrow">Compra · Nuevo pedido</div>
                <h1>Nueva compra</h1>
                <p>Selecciona el artículo, la cantidad y adjunta tu comprobante de pago.</p>
            </div>
        </div>

        @if($errors->any())
            <div class="alert alert-error">
                <div>
                    @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
                </div>
            </div>
        @endif

        @if($productos->isEmpty())
            <p class="muted" style="padding:2rem 0;text-align:center">No hay artículos con stock disponible.</p>
        @else
            <form action="{{ route('ventas.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <label for="producto_id">Artículo</label>
                <select id="producto_id" name="producto_id" required>
                    <option value="">— Selecciona —</option>
                    @foreach($productos as $p)
                        <option value="{{ $p->id }}"
                            @selected(old('producto_id', $producto?->id) == $p->id)
                            data-precio="{{ $p->precio }}" data-stock="{{ $p->stock }}">
                            {{ $p->nombre }} — ${{ number_format($p->precio, 2) }} (stock: {{ $p->stock }})
                        </option>
                    @endforeach
                </select>

                <label for="cantidad">Cantidad</label>
                <input type="number" id="cantidad" name="cantidad" min="1" value="{{ old('cantidad', 1) }}" required>

                <label for="ticket">Comprobante de pago <small>(jpg, jpeg, png · máx 4MB)</small></label>
                <input type="file" id="ticket" name="ticket" accept="image/jpeg,image/png" required>

                <div class="row" style="margin-top:1.25rem">
                    <button type="submit">Confirmar compra</button>
                    <a class="btn btn-secondary" href="{{ route('productos.index') }}">Cancelar</a>
                </div>
            </form>
        @endif
    </div>
@endsection
