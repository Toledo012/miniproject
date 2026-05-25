@extends('layouts.app')

@section('title', config('app.name'))

@section('content')
    <div class="card" style="text-align:center;padding:4rem 2rem">
        <div style="font-size:.7rem;letter-spacing:.3em;text-transform:uppercase;color:var(--champagne-dark);font-weight:600;margin-bottom:.6rem">
            Bienvenido
        </div>
        <h1 style="font-size:2.5rem;margin-bottom:1rem">{{ config('app.name') }}</h1>
        <p class="muted" style="max-width:520px;margin:0 auto 1.75rem">
            Una experiencia de compra cuidada al detalle. Explora el catálogo o accede a tu cuenta para continuar.
        </p>
        <div class="row" style="justify-content:center">
            <a class="btn" href="{{ route('catalogo') }}">Ver catálogo</a>
            @guest
                <a class="btn btn-secondary" href="{{ route('login') }}">Iniciar sesión</a>
            @endguest
        </div>
    </div>
@endsection
