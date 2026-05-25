@extends('layouts.app')

@section('title', 'Panel')

@section('content')
    <div class="card">
        <div class="page-header" style="border-bottom:0;padding-bottom:0;margin-bottom:0">
            <div>
                <div class="eyebrow">Vista general</div>
                <h1>Panel administrativo</h1>
                <p>Resumen estadístico de la plataforma.</p>
            </div>
        </div>
    </div>

    <div class="stat-grid">
        <div class="stat">
            <div class="lbl">Usuarios</div>
            <div class="num">{{ $totales['usuarios'] }}</div>
            <div class="sub">total registrados</div>
        </div>
        <div class="stat">
            <div class="lbl">Productos</div>
            <div class="num">{{ $totales['productos'] }}</div>
            <div class="sub">en catálogo</div>
        </div>
        <div class="stat">
            <div class="lbl">Categorías</div>
            <div class="num">{{ $totales['categorias'] }}</div>
            <div class="sub">organización</div>
        </div>
        <div class="stat">
            <div class="lbl">Vendedores</div>
            <div class="num">{{ $totales['vendedores'] }}</div>
            <div class="sub">activos</div>
        </div>
        <div class="stat">
            <div class="lbl">Compradores</div>
            <div class="num">{{ $totales['compradores'] }}</div>
            <div class="sub">activos</div>
        </div>
        <div class="stat">
            <div class="lbl">Gerentes</div>
            <div class="num">{{ $totales['gerentes'] }}</div>
            <div class="sub">supervisión</div>
        </div>
        <div class="stat">
            <div class="lbl">Administradores</div>
            <div class="num">{{ $totales['admins'] }}</div>
            <div class="sub">acceso total</div>
        </div>
    </div>

    <div class="card">
        <h2>Productos por categoría</h2>
        <div class="table-wrap">
            <table>
                <thead><tr><th>Categoría</th><th style="text-align:right">Productos</th></tr></thead>
                <tbody>
                    @forelse ($productosPorCategoria as $categoria)
                        <tr>
                            <td><strong>{{ $categoria->nombre }}</strong></td>
                            <td style="text-align:right">{{ $categoria->productos_count }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="2" class="muted">Sin categorías registradas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card" style="background:linear-gradient(135deg,var(--cream),var(--surface-2));border:1px solid var(--line-strong)">
        <div class="eyebrow">Destacado</div>
        <h2 style="margin-top:.5rem">Artículo más vendido</h2>
        @if ($productoTop && $productoTop->ventas_validadas_count > 0)
            <p style="font-size:1.1rem;margin:0">
                <strong style="font-family:'Playfair Display',serif;font-size:1.4rem">{{ $productoTop->nombre }}</strong>
                <span class="muted">— {{ $productoTop->ventas_validadas_count }} venta(s) validada(s).</span>
            </p>
        @else
            <p class="muted">Aún no hay ventas validadas.</p>
        @endif
    </div>

    <div class="card">
        <h2>Comprador más frecuente por categoría</h2>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Categoría</th>
                        <th>Comprador</th>
                        <th style="text-align:right">Compras validadas</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($compradoresPorCategoria as $fila)
                        <tr>
                            <td><strong>{{ $fila['categoria']->nombre }}</strong></td>
                            <td>{{ $fila['comprador']?->nombre ?? '—' }}</td>
                            <td style="text-align:right">{{ $fila['compras'] }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="muted">Sin datos suficientes.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
