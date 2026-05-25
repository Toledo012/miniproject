@extends('layouts.app')

@section('title', 'Usuario')

@section('content')
    <div class="card">
        <div class="page-header">
            <div style="display:flex;align-items:center;gap:1rem">
                <div style="width:64px;height:64px;border-radius:50%;background:linear-gradient(135deg,var(--champagne),var(--champagne-dark));color:var(--ink);font-weight:700;font-size:1.5rem;display:flex;align-items:center;justify-content:center;font-family:'Playfair Display',serif">
                    {{ strtoupper(mb_substr($usuario->nombre, 0, 1)) }}
                </div>
                <div>
                    <div class="eyebrow">Perfil de usuario</div>
                    <h1 style="margin:0">{{ $usuario->nombre }}</h1>
                </div>
            </div>
            <div class="row">
                @can('update', $usuario)
                    <a class="btn" href="{{ route('users.edit', $usuario) }}">Editar</a>
                @endcan
                <a class="btn btn-ghost" href="{{ route('users.index') }}">← Volver</a>
            </div>
        </div>

        <div class="stat-grid">
            <div class="stat">
                <div class="lbl">Email</div>
                <div class="num" style="font-size:1.15rem;font-family:inherit;font-weight:500">{{ $usuario->email }}</div>
            </div>
            <div class="stat">
                <div class="lbl">Rol</div>
                <div style="margin-top:.6rem"><span class="badge badge-{{ ['admin'=>'rechazada','gerente'=>'validada','vendedor'=>'pendiente','comprador'=>'validada'][$usuario->rol] ?? 'pendiente' }}">{{ ucfirst($usuario->rol) }}</span></div>
            </div>
            <div class="stat">
                <div class="lbl">Compras</div>
                <div class="num">{{ $usuario->compras_count ?? 0 }}</div>
            </div>
            <div class="stat">
                <div class="lbl">Publicados</div>
                <div class="num">{{ $usuario->productos_count ?? 0 }}</div>
            </div>
            <div class="stat">
                <div class="lbl">Registrado</div>
                <div class="num" style="font-size:1.05rem;font-family:inherit;font-weight:500">{{ $usuario->created_at?->format('Y-m-d H:i') }}</div>
            </div>
        </div>
    </div>
@endsection
