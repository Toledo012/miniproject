@extends('layouts.app')

@section('title', 'Categorías')

@section('content')
    <div class="card">
        <div class="page-header">
            <div>
                <div class="eyebrow">Organización</div>
                <h1>Categorías</h1>
                <p>Agrupa tus artículos para que tus clientes los encuentren más rápido.</p>
            </div>
            @can('create', App\Models\Categoria::class)
                <a class="btn" href="{{ route('categorias.create') }}">+ Nueva categoría</a>
            @endcan
        </div>

        @if($categorias->isEmpty())
            <p class="muted" style="padding:2rem 0;text-align:center">No hay categorías registradas.</p>
        @else
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Slug</th>
                            <th>Artículos</th>
                            <th style="text-align:right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categorias as $categoria)
                            <tr>
                                <td><strong>{{ $categoria->nombre }}</strong></td>
                                <td><code>{{ $categoria->slug }}</code></td>
                                <td>{{ $categoria->productos_count }}</td>
                                <td style="text-align:right">
                                    <a class="btn btn-secondary btn-sm" href="{{ route('categorias.show', $categoria) }}">Ver</a>
                                    @can('update', $categoria)
                                        <a class="btn btn-sm" href="{{ route('categorias.edit', $categoria) }}">Editar</a>
                                    @endcan
                                    @can('delete', $categoria)
                                        <form class="inline" action="{{ route('categorias.destroy', $categoria) }}" method="POST" onsubmit="return confirm('¿Eliminar categoría?')">
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
            <div>{{ $categorias->links() }}</div>
        @endif
    </div>
@endsection
