@extends('layouts.app')

@section('title', 'Editar usuario')

@section('content')
    <div class="card" style="max-width:640px;margin:0 auto">
        <div class="page-header">
            <div>
                <div class="eyebrow">Administración · Edición</div>
                <h1>Editar usuario</h1>
                <p>Actualiza los datos de <strong>{{ $usuario->nombre }}</strong>.</p>
            </div>
        </div>

        @if($errors->any())
            <div class="alert alert-error">
                <div>
                    @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
                </div>
            </div>
        @endif

        <form action="{{ route('users.update', $usuario) }}" method="POST">
            @csrf
            @method('PUT')

            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $usuario->nombre) }}" required maxlength="255" autofocus>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', $usuario->email) }}" required maxlength="255">

            <label for="rol">Rol</label>
            <select id="rol" name="rol" required>
                @foreach(['comprador','vendedor','gerente','admin'] as $rol)
                    <option value="{{ $rol }}" @selected(old('rol', $usuario->rol)===$rol)>{{ ucfirst($rol) }}</option>
                @endforeach
            </select>

            <div class="form-row">
                <div>
                    <label for="password">Nueva contraseña <small>(opcional)</small></label>
                    <input type="password" id="password" name="password" minlength="8">
                </div>
                <div>
                    <label for="password_confirmation">Confirmar nueva contraseña</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" minlength="8">
                </div>
            </div>

            <div class="row" style="margin-top:1rem">
                <button type="submit">Guardar cambios</button>
                <a class="btn btn-secondary" href="{{ route('users.index') }}">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
