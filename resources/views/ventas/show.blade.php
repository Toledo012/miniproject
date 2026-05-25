@extends('layouts.app')

@section('title', 'Venta #' . $venta->id)

@section('content')
    <div class="card">
        <div class="page-header">
            <div>
                <div class="eyebrow">Operación</div>
                <h1>Venta #{{ $venta->id }} <span class="badge badge-{{ $venta->estado }}" style="margin-left:.5rem;vertical-align:middle">{{ $venta->estado }}</span></h1>
                <p>{{ $venta->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div class="row">
                @can('verTicket', $venta)
                    <a class="btn" href="{{ route('ventas.ticket', $venta) }}">Descargar ticket</a>
                @endcan
                <a class="btn btn-ghost" href="{{ route('ventas.index') }}">← Volver</a>
            </div>
        </div>

        <div class="table-wrap" style="max-width:640px">
            <table>
                <tbody>
                    <tr><th style="background:transparent;border-bottom:1px solid var(--line);text-transform:none;letter-spacing:0;font-size:.85rem;color:var(--muted);font-weight:500">Comprador</th><td>{{ $venta->comprador->nombre }}</td></tr>
                    <tr><th style="background:transparent;border-bottom:1px solid var(--line);text-transform:none;letter-spacing:0;font-size:.85rem;color:var(--muted);font-weight:500">Artículo</th><td><strong>{{ $venta->producto->nombre }}</strong></td></tr>
                    @if($venta->producto->vendedor)
                        <tr><th style="background:transparent;border-bottom:1px solid var(--line);text-transform:none;letter-spacing:0;font-size:.85rem;color:var(--muted);font-weight:500">Vendedor</th><td>{{ $venta->producto->vendedor->nombre }}</td></tr>
                    @endif
                    <tr><th style="background:transparent;border-bottom:1px solid var(--line);text-transform:none;letter-spacing:0;font-size:.85rem;color:var(--muted);font-weight:500">Precio unitario</th><td>${{ number_format($venta->producto->precio, 2) }}</td></tr>
                    <tr><th style="background:transparent;border-bottom:1px solid var(--line);text-transform:none;letter-spacing:0;font-size:.85rem;color:var(--muted);font-weight:500">Cantidad</th><td>{{ $venta->cantidad }}</td></tr>
                    <tr><th style="background:transparent;border-bottom:1px solid var(--line);text-transform:none;letter-spacing:0;font-size:.85rem;color:var(--muted);font-weight:500">Total</th><td><strong style="font-family:'Playfair Display',serif;font-size:1.25rem">${{ number_format($venta->total, 2) }}</strong></td></tr>
                    <tr><th style="background:transparent;border-bottom:0;text-transform:none;letter-spacing:0;font-size:.85rem;color:var(--muted);font-weight:500">Validado por</th><td>{{ $venta->gerente?->nombre ?? '—' }}</td></tr>
                </tbody>
            </table>
        </div>

        @can('update', $venta)
            @if($venta->estado === 'pendiente')
                <hr class="divider">
                <div class="row">
                    <form class="inline" action="{{ route('ventas.update', $venta) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="estado" value="validada">
                        <button type="submit" onclick="return confirm('¿Validar esta venta?')">✓ Validar venta</button>
                    </form>
                    <form class="inline" action="{{ route('ventas.update', $venta) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="estado" value="rechazada">
                        <button class="btn-danger" type="submit" onclick="return confirm('¿Rechazar esta venta?')">✕ Rechazar venta</button>
                    </form>
                </div>
            @endif
        @endcan
    </div>
@endsection
