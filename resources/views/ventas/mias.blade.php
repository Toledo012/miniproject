@extends('layouts.app')

@section('title', 'Mis compras')

@section('content')
    <div class="card">
        <div class="page-header">
            <div>
                <div class="eyebrow">Historial</div>
                <h1>Mis compras</h1>
                <p>Aquí puedes ver el estado de cada uno de tus pedidos.</p>
            </div>
            <a class="btn" href="{{ route('ventas.create') }}">+ Nueva compra</a>
        </div>

        @if($ventas->isEmpty())
            <p class="muted" style="padding:2rem 0;text-align:center">
                Aún no has realizado compras. <a href="{{ route('productos.index') }}">Explorar el catálogo</a>.
            </p>
        @else
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Artículo</th>
                            <th>Cant.</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ventas as $venta)
                            <tr>
                                <td><strong>#{{ $venta->id }}</strong></td>
                                <td>{{ $venta->producto->nombre }}</td>
                                <td>{{ $venta->cantidad }}</td>
                                <td><strong>${{ number_format($venta->total, 2) }}</strong></td>
                                <td><span class="badge badge-{{ $venta->estado }}">{{ $venta->estado }}</span></td>
                                <td class="muted" style="font-size:.82rem">{{ $venta->created_at->format('Y-m-d H:i') }}</td>
                                <td><a class="btn btn-secondary btn-sm" href="{{ route('ventas.show', $venta) }}">Ver</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div>{{ $ventas->links() }}</div>
        @endif
    </div>
@endsection
