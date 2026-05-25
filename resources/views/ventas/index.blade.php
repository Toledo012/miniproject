@extends('layouts.app')

@section('title', 'Ventas')

@php
    $u = auth()->user();
    $tituloVentas = $u?->esVendedor()
        ? 'Ventas de mis artículos'
        : ($u?->esComprador() ? 'Mis compras' : 'Todas las ventas');
    $eyebrowVentas = $u?->esComprador() ? 'Historial' : 'Operaciones';
@endphp

@section('content')
    <div class="card">
        <div class="page-header">
            <div>
                <div class="eyebrow">{{ $eyebrowVentas }}</div>
                <h1>{{ $tituloVentas }}</h1>
                <p>Filtra por estado para ver el detalle de cada operación.</p>
            </div>
            @if($u?->esComprador())
                <a class="btn" href="{{ route('ventas.create') }}">+ Nueva compra</a>
            @endif
        </div>

        <div class="seg" style="margin-bottom:1.25rem">
            <a class="@if(!$estado) active @endif" href="{{ route('ventas.index') }}">Todas</a>
            <a class="@if($estado==='pendiente') active @endif" href="{{ route('ventas.index', ['estado'=>'pendiente']) }}">Pendientes</a>
            <a class="@if($estado==='validada') active @endif" href="{{ route('ventas.index', ['estado'=>'validada']) }}">Validadas</a>
            <a class="@if($estado==='rechazada') active @endif" href="{{ route('ventas.index', ['estado'=>'rechazada']) }}">Rechazadas</a>
        </div>

        @if($ventas->isEmpty())
            <p class="muted" style="padding:2rem 0;text-align:center">No hay ventas registradas.</p>
        @else
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Comprador</th>
                            <th>Artículo</th>
                            <th>Cant.</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th>Validado por</th>
                            <th>Fecha</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ventas as $venta)
                            <tr>
                                <td><strong>#{{ $venta->id }}</strong></td>
                                <td>{{ $venta->comprador->nombre }}</td>
                                <td>{{ $venta->producto->nombre }}</td>
                                <td>{{ $venta->cantidad }}</td>
                                <td><strong>${{ number_format($venta->total, 2) }}</strong></td>
                                <td><span class="badge badge-{{ $venta->estado }}">{{ $venta->estado }}</span></td>
                                <td class="muted">{{ $venta->gerente?->nombre ?? '—' }}</td>
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
