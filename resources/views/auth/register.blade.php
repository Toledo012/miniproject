@extends('layouts.app')

@section('title', 'Crear cuenta')

@section('content')
<style>
    .auth-shell{
        display:grid;grid-template-columns:1fr 1.05fr;
        min-height:calc(100vh - 64px);background:var(--bg);
    }
    /* Aquí invertimos: branding a la derecha */
    .auth-form-side{
        display:flex;align-items:center;justify-content:center;
        padding:3rem 2rem;background:var(--bg);position:relative;order:1;
    }
    .auth-form-side::before{
        content:"";position:absolute;top:0;left:0;width:300px;height:300px;
        background:radial-gradient(circle,var(--cream) 0%,transparent 70%);opacity:.6;pointer-events:none;
    }
    .auth-card{width:100%;max-width:460px;position:relative;z-index:1}
    .auth-card .eyebrow{
        font-size:.7rem;letter-spacing:.3em;text-transform:uppercase;
        color:var(--champagne-dark);font-weight:600;margin-bottom:.75rem;
    }
    .auth-card h2{
        font-family:'Playfair Display',serif;font-size:2.5rem;font-weight:600;
        letter-spacing:-.02em;margin:0 0 .5rem;color:var(--ink);
    }
    .auth-card .sub{color:var(--muted);margin-bottom:2rem;font-size:1rem}

    .auth-alert{
        background:#fff;border-left:3px solid var(--bad-ink);
        padding:.9rem 1rem;margin-bottom:1.25rem;border-radius:0 8px 8px 0;
        box-shadow:0 2px 8px rgba(0,0,0,.04);
    }
    .auth-alert div{color:var(--bad-ink);font-size:.9rem;line-height:1.5}

    .field{position:relative;margin-bottom:1rem}
    .field input{
        width:100%;padding:1.4rem 1rem .6rem 3rem;
        border:1.5px solid var(--line-strong);background:#fff;border-radius:10px;
        font-size:1rem;font-family:inherit;color:var(--ink);
        transition:all .25s ease;margin:0;
    }
    .field input:hover{border-color:#b8ad97}
    .field input:focus{outline:none;border-color:var(--ink);box-shadow:0 0 0 4px rgba(10,10,10,.06)}
    .field label{
        position:absolute;left:3rem;top:50%;transform:translateY(-50%);
        color:var(--muted-2);font-size:1rem;font-weight:400;
        pointer-events:none;transition:all .2s ease;background:transparent;margin:0;
    }
    .field input:focus + label,
    .field input:not(:placeholder-shown) + label{
        top:.55rem;transform:translateY(0);
        font-size:.68rem;font-weight:600;color:var(--champagne-dark);
        letter-spacing:.12em;text-transform:uppercase;
    }
    .field .icon{
        position:absolute;left:1rem;top:50%;transform:translateY(-50%);
        color:var(--muted-2);pointer-events:none;
    }
    .field input:focus ~ .icon{color:var(--ink)}

    .role-label{
        display:block;font-size:.72rem;letter-spacing:.18em;text-transform:uppercase;
        color:var(--muted);font-weight:600;margin:1.25rem 0 .65rem;
    }
    .role-grid{display:grid;grid-template-columns:1fr 1fr;gap:.65rem;margin-bottom:1.5rem}
    .role-opt{
        position:relative;cursor:pointer;
        border:1.5px solid var(--line-strong);border-radius:12px;
        padding:1rem 1rem 1rem 3rem;background:#fff;
        transition:all .2s ease;
    }
    .role-opt:hover{border-color:var(--ink)}
    .role-opt input{
        position:absolute;left:1rem;top:1.2rem;width:auto;margin:0;accent-color:var(--ink);
    }
    .role-opt strong{
        display:block;font-family:'Playfair Display',serif;font-size:1.05rem;color:var(--ink);
    }
    .role-opt small{display:block;color:var(--muted);font-size:.78rem;margin-top:.15rem}
    .role-opt:has(input:checked){
        border-color:var(--ink);background:var(--cream);
        box-shadow:0 0 0 4px rgba(10,10,10,.04);
    }

    .btn-cta{
        width:100%;background:var(--ink);color:var(--bg);
        border:0;padding:1.05rem 1.5rem;border-radius:10px;
        font-size:.9rem;font-weight:600;letter-spacing:.05em;text-transform:uppercase;
        cursor:pointer;display:flex;align-items:center;justify-content:center;gap:.75rem;
        position:relative;overflow:hidden;transition:transform .2s ease,box-shadow .2s ease;
        box-shadow:0 4px 14px rgba(0,0,0,.15);
    }
    .btn-cta::before{
        content:"";position:absolute;inset:0;
        background:linear-gradient(120deg,transparent 0%,rgba(201,168,118,.25) 50%,transparent 100%);
        transform:translateX(-100%);transition:transform .6s ease;
    }
    .btn-cta:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(0,0,0,.25)}
    .btn-cta:hover::before{transform:translateX(100%)}
    .btn-cancel{
        display:inline-block;width:100%;text-align:center;margin-top:.75rem;
        padding:.85rem;color:var(--muted);font-size:.85rem;text-decoration:none;
        border-radius:10px;transition:all .2s;
    }
    .btn-cancel:hover{background:var(--cream);color:var(--ink)}

    /* Brand */
    .auth-brand{
        position:relative;order:2;
        background:
            radial-gradient(circle at 80% 10%, #1f1f1f 0%, transparent 55%),
            radial-gradient(circle at 20% 90%, #161616 0%, transparent 50%),
            linear-gradient(225deg, #0a0a0a 0%, #1a1a1a 100%);
        color:#f7f3ec;padding:4rem 4rem 3rem;
        display:flex;flex-direction:column;justify-content:space-between;overflow:hidden;
    }
    .auth-brand::before{
        content:"";position:absolute;top:-150px;left:-150px;
        width:500px;height:500px;border-radius:50%;
        background:radial-gradient(circle,rgba(201,168,118,.12) 0%,transparent 70%);
    }
    .auth-brand::after{
        content:"";position:absolute;bottom:-200px;right:-100px;
        width:450px;height:450px;border-radius:50%;
        background:radial-gradient(circle,rgba(201,168,118,.08) 0%,transparent 70%);
    }
    .brand-mark{
        display:flex;align-items:center;gap:.6rem;justify-content:flex-end;
        font-size:.78rem;letter-spacing:.3em;text-transform:uppercase;
        color:var(--champagne);position:relative;z-index:1;
    }
    .brand-mark .dot{
        width:8px;height:8px;background:var(--champagne);border-radius:50%;
        box-shadow:0 0 12px var(--champagne);
    }
    .brand-hero{position:relative;z-index:1;margin:auto 0;text-align:right}
    .brand-hero h1{
        font-family:'Playfair Display',serif;
        font-size:clamp(2.5rem,4.2vw,4rem);font-weight:500;
        line-height:1.05;letter-spacing:-.02em;margin:0 0 1.5rem;color:#f7f3ec;
    }
    .brand-hero h1 em{
        font-style:italic;font-weight:600;
        background:linear-gradient(120deg,var(--champagne),#e8c896);
        -webkit-background-clip:text;background-clip:text;color:transparent;
    }
    .brand-hero p{color:#a8a39a;font-size:1.05rem;line-height:1.7;max-width:480px;margin-left:auto}
    .brand-bullets{
        position:relative;z-index:1;display:flex;flex-direction:column;gap:.85rem;
        margin-top:3rem;padding-top:2rem;border-top:1px solid #2a2a2a;
    }
    .brand-bullet{
        display:flex;justify-content:flex-end;align-items:center;gap:.85rem;
        color:#cfc8bb;font-size:.92rem;
    }
    .brand-bullet .ico{
        width:32px;height:32px;border-radius:50%;
        background:rgba(201,168,118,.12);border:1px solid rgba(201,168,118,.3);
        display:flex;align-items:center;justify-content:center;color:var(--champagne);
    }

    @media (max-width:900px){
        .auth-shell{grid-template-columns:1fr}
        .auth-brand{order:1;padding:2.5rem 2rem;min-height:260px}
        .auth-form-side{order:2;padding:2.5rem 1.25rem}
        .brand-hero{text-align:left}
        .brand-hero p{margin-left:0}
        .brand-bullets{display:none}
        .brand-mark{justify-content:flex-start}
        .role-grid{grid-template-columns:1fr}
    }
</style>

<div class="auth-shell">
    <section class="auth-form-side">
        <div class="auth-card">
            <div class="eyebrow">Nuevo · Registro</div>
            <h2>Crear cuenta</h2>
            <p class="sub">Únete en menos de un minuto.</p>

            @if($errors->any())
                <div class="auth-alert">
                    @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
                </div>
            @endif

            <form action="{{ route('register.attempt') }}" method="POST" novalidate>
                @csrf

                <div class="field">
                    <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" placeholder=" " required maxlength="255" autofocus>
                    <label for="nombre">Nombre completo</label>
                    <span class="icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </span>
                </div>

                <div class="field">
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder=" " required maxlength="255">
                    <label for="email">Correo electrónico</label>
                    <span class="icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg>
                    </span>
                </div>

                <div class="field">
                    <input type="password" id="password" name="password" placeholder=" " required minlength="8">
                    <label for="password">Contraseña</label>
                    <span class="icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="11" width="16" height="10" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/></svg>
                    </span>
                </div>

                <div class="field">
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder=" " required minlength="8">
                    <label for="password_confirmation">Confirmar contraseña</label>
                    <span class="icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12l2 2 4-4"/><circle cx="12" cy="12" r="9"/></svg>
                    </span>
                </div>

                <div class="role-label">Quiero registrarme como</div>
                <div class="role-grid">
                    <label class="role-opt">
                        <input type="radio" name="rol" value="comprador" @checked(old('rol','comprador')==='comprador')>
                        <strong>Comprador</strong>
                        <small>Quiero realizar compras</small>
                    </label>
                    <label class="role-opt">
                        <input type="radio" name="rol" value="vendedor" @checked(old('rol')==='vendedor')>
                        <strong>Vendedor</strong>
                        <small>Quiero publicar artículos</small>
                    </label>
                </div>

                <button type="submit" class="btn-cta">
                    <span>Crear mi cuenta</span>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </button>
                <a class="btn-cancel" href="{{ route('login') }}">Ya tengo cuenta · iniciar sesión</a>
            </form>
        </div>
    </section>

    <aside class="auth-brand">
        <div class="brand-mark">
            <span>{{ config('app.name') }} · Bienvenida</span>
            <span class="dot"></span>
        </div>

        <div class="brand-hero">
            <h1>Empieza tu <em>experiencia</em>.</h1>
            <p>Crea una cuenta para guardar favoritos, hacer seguimiento de tus pedidos y acceder a beneficios exclusivos.</p>
        </div>

        <div class="brand-bullets">
            <div class="brand-bullet">
                <span>Acceso a colecciones exclusivas</span>
                <span class="ico"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span>
            </div>
            <div class="brand-bullet">
                <span>Seguimiento de pedidos en tiempo real</span>
                <span class="ico"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span>
            </div>
            <div class="brand-bullet">
                <span>Soporte personalizado 24/7</span>
                <span class="ico"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span>
            </div>
        </div>
    </aside>
</div>
@endsection
