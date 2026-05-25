@extends('layouts.app')

@section('title', 'Nuevo usuario')

@section('content')
    <div class="card" style="max-width:640px;margin:0 auto">
        <div class="page-header">
            <div>
                <div class="eyebrow">Administración · Alta</div>
                <h1>Nuevo usuario</h1>
                <p>Crea una cuenta con un rol específico.</p>
            </div>
        </div>

        @if($errors->any())
            <div class="alert alert-error">
                <div>
                    @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
                </div>
            </div>
        @endif

        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required maxlength="255" autofocus>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required maxlength="255">

            <label for="rol">Rol</label>
            <select id="rol" name="rol" required>
                <option value="comprador" @selected(old('rol','comprador')==='comprador')>Comprador</option>
                <option value="vendedor"  @selected(old('rol')==='vendedor')>Vendedor</option>
                <option value="gerente"   @selected(old('rol')==='gerente')>Gerente</option>
                <option value="admin"     @selected(old('rol')==='admin')>Admin</option>
            </select>

            <div class="form-row">
                <div>
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" required minlength="8">
                </div>
                <div>
                    <label for="password_confirmation">Confirmar contraseña</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required minlength="8">
                </div>
            </div>

            <div class="row" style="margin-top:1rem">
                <button type="submit">Crear usuario</button>
                <a class="btn btn-secondary" href="{{ route('users.index') }}">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
