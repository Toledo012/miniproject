@extends('layouts.app')

@section('title', 'Usuarios')

@section('content')
    <div class="card">
        <div class="page-header">
            <div>
                <div class="eyebrow">Administración</div>
                <h1>Usuarios</h1>
                <p>Gestiona los accesos y los roles de la plataforma.</p>
            </div>
            @can('create', App\Models\User::class)
                <a class="btn" href="{{ route('users.create') }}">+ Nuevo usuario</a>
            @endcan
        </div>

        <form method="GET" action="{{ route('users.index') }}" class="filter-bar" style="margin-bottom:1.25rem">
            <div>
                <label for="q">Buscar</label>
                <input type="text" id="q" name="q" value="{{ request('q') }}" placeholder="Nombre o email">
            </div>
            <div style="max-width:220px">
                <label for="rol">Rol</label>
                <select id="rol" name="rol">
                    <option value="">Todos</option>
                    <option value="admin"     @selected(request('rol')==='admin')>Admin</option>
                    <option value="gerente"   @selected(request('rol')==='gerente')>Gerente</option>
                    <option value="vendedor"  @selected(request('rol')==='vendedor')>Vendedor</option>
                    <option value="comprador" @selected(request('rol')==='comprador')>Comprador</option>
                </select>
            </div>
            <div><button type="submit">Filtrar</button></div>
        </form>

        @if($usuarios->isEmpty())
            <p class="muted" style="padding:2rem 0;text-align:center">No hay usuarios registrados.</p>
        @else
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th style="text-align:right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($usuarios as $usuario)
                            <tr>
                                <td>
                                    <div style="display:flex;align-items:center;gap:.7rem">
                                        <div style="width:34px;height:34px;border-radius:50%;background:linear-gradient(135deg,var(--champagne),var(--champagne-dark));color:var(--ink);font-weight:600;font-size:.85rem;display:flex;align-items:center;justify-content:center">
                                            {{ strtoupper(mb_substr($usuario->nombre, 0, 1)) }}
                                        </div>
                                        <strong>{{ $usuario->nombre }}</strong>
                                    </div>
                                </td>
                                <td class="muted">{{ $usuario->email }}</td>
                                <td><span class="badge badge-{{ ['admin'=>'rechazada','gerente'=>'validada','vendedor'=>'pendiente','comprador'=>'validada'][$usuario->rol] ?? 'pendiente' }}">{{ ucfirst($usuario->rol) }}</span></td>
                                <td style="text-align:right">
                                    <a class="btn btn-secondary btn-sm" href="{{ route('users.show', $usuario) }}">Ver</a>
                                    @can('update', $usuario)
                                        <a class="btn btn-sm" href="{{ route('users.edit', $usuario) }}">Editar</a>
                                    @endcan
                                    @can('delete', $usuario)
                                        <form class="inline" action="{{ route('users.destroy', $usuario) }}" method="POST" onsubmit="return confirm('¿Eliminar usuario?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn-danger btn-sm">Eliminar</button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div>{{ $usuarios->links() }}</div>
        @endif
    </div>
@endsection
