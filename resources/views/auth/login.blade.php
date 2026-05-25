@extends('layouts.app')

@section('title', 'Iniciar sesión')

@section('content')
<style>
    .auth-shell{
        display:grid;
        grid-template-columns:1.05fr 1fr;
        min-height:calc(100vh - 64px);
        background:var(--bg);
    }

    /* ============ LADO IZQUIERDO: BRANDING ============ */
    .auth-brand{
        position:relative;
        background:
            radial-gradient(circle at 20% 10%, #1f1f1f 0%, transparent 55%),
            radial-gradient(circle at 80% 90%, #161616 0%, transparent 50%),
            linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 100%);
        color:#f7f3ec;
        padding:4rem 4rem 3rem;
        display:flex;flex-direction:column;justify-content:space-between;
        overflow:hidden;
    }
    .auth-brand::before{
        content:"";position:absolute;top:-150px;right:-150px;
        width:500px;height:500px;border-radius:50%;
        background:radial-gradient(circle,rgba(201,168,118,.12) 0%,transparent 70%);
        pointer-events:none;
    }
    .auth-brand::after{
        content:"";position:absolute;bottom:-200px;left:-100px;
        width:450px;height:450px;border-radius:50%;
        background:radial-gradient(circle,rgba(201,168,118,.08) 0%,transparent 70%);
        pointer-events:none;
    }
    .brand-mark{
        display:flex;align-items:center;gap:.6rem;
        font-size:.78rem;letter-spacing:.3em;text-transform:uppercase;
        color:var(--champagne);position:relative;z-index:1;
    }
    .brand-mark .dot{
        width:8px;height:8px;background:var(--champagne);border-radius:50%;
        box-shadow:0 0 12px var(--champagne);
    }
    .brand-hero{position:relative;z-index:1;margin:auto 0}
    .brand-hero h1{
        font-family:'Playfair Display',serif;
        font-size:clamp(2.5rem,4.5vw,4.25rem);
        font-weight:500;line-height:1.05;letter-spacing:-.02em;
        margin:0 0 1.5rem;color:#f7f3ec;
    }
    .brand-hero h1 em{
        font-style:italic;font-weight:600;
        background:linear-gradient(120deg,var(--champagne),#e8c896);
        -webkit-background-clip:text;background-clip:text;color:transparent;
    }
    .brand-hero p{color:#a8a39a;font-size:1.05rem;line-height:1.7;max-width:480px;margin:0}
    .brand-features{
        position:relative;z-index:1;
        display:flex;gap:2.5rem;margin-top:3rem;
        padding-top:2rem;border-top:1px solid #2a2a2a;
    }
    .brand-feature{flex:1}
    .brand-feature .num{
        font-family:'Playfair Display',serif;
        font-size:1.85rem;font-weight:600;color:var(--champagne);
        letter-spacing:-.02em;
    }
    .brand-feature .lbl{
        font-size:.72rem;color:#8a857c;text-transform:uppercase;letter-spacing:.18em;margin-top:.25rem;
    }

    /* ============ LADO DERECHO: FORMULARIO ============ */
    .auth-form-side{
        display:flex;align-items:center;justify-content:center;
        padding:3rem 2rem;background:var(--bg);position:relative;
    }
    .auth-form-side::before{
        content:"";position:absolute;top:0;right:0;width:300px;height:300px;
        background:radial-gradient(circle,var(--cream) 0%,transparent 70%);
        opacity:.6;pointer-events:none;
    }
    .auth-card{width:100%;max-width:440px;position:relative;z-index:1}
    .auth-card .eyebrow{
        font-size:.7rem;letter-spacing:.3em;text-transform:uppercase;
        color:var(--champagne-dark);font-weight:600;margin-bottom:.75rem;
    }
    .auth-card h2{
        font-family:'Playfair Display',serif;
        font-size:2.5rem;font-weight:600;letter-spacing:-.02em;
        margin:0 0 .5rem;color:var(--ink);
    }
    .auth-card .sub{color:var(--muted);margin-bottom:2.5rem;font-size:1rem}

    .auth-alert{
        background:#fff;border-left:3px solid var(--bad-ink);
        padding:.9rem 1rem;margin-bottom:1.5rem;border-radius:0 8px 8px 0;
        box-shadow:0 2px 8px rgba(0,0,0,.04);
    }
    .auth-alert div{color:var(--bad-ink);font-size:.9rem;line-height:1.5}

    /* Floating label fields */
    .field{position:relative;margin-bottom:1.25rem}
    .field input{
        width:100%;padding:1.4rem 1rem .6rem 3rem;
        border:1.5px solid var(--line-strong);background:#fff;
        border-radius:10px;font-size:1rem;font-family:inherit;color:var(--ink);
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
        color:var(--muted-2);pointer-events:none;transition:color .2s ease;
    }
    .field input:focus ~ .icon{color:var(--ink)}
    .field .toggle-pass{
        position:absolute;right:.75rem;top:50%;transform:translateY(-50%);
        background:transparent;border:0;cursor:pointer;color:var(--muted-2);
        padding:.4rem;border-radius:6px;display:flex;align-items:center;
        box-shadow:none;
    }
    .field .toggle-pass:hover{color:var(--ink);background:rgba(0,0,0,.04);transform:translateY(-50%)}

    .row-extras{
        display:flex;justify-content:space-between;align-items:center;
        margin:.5rem 0 1.75rem;font-size:.9rem;
    }
    .check{display:flex;align-items:center;gap:.5rem;cursor:pointer;color:var(--muted)}
    .check input{width:auto;margin:0;accent-color:var(--ink)}
    .forgot{
        color:var(--ink);text-decoration:none;font-weight:500;
        border-bottom:1px solid transparent;transition:border-color .2s;
    }
    .forgot:hover{border-color:var(--ink)}

    /* CTA */
    .btn-cta{
        width:100%;background:var(--ink);color:var(--bg);
        border:0;padding:1.1rem 1.5rem;border-radius:10px;
        font-size:.95rem;font-weight:600;letter-spacing:.05em;text-transform:uppercase;
        cursor:pointer;display:flex;align-items:center;justify-content:center;gap:.75rem;
        position:relative;overflow:hidden;
        transition:transform .2s ease, box-shadow .2s ease;
        box-shadow:0 4px 14px rgba(0,0,0,.15);
    }
    .btn-cta::before{
        content:"";position:absolute;inset:0;
        background:linear-gradient(120deg,transparent 0%,rgba(201,168,118,.25) 50%,transparent 100%);
        transform:translateX(-100%);transition:transform .6s ease;
    }
    .btn-cta:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(0,0,0,.25)}
    .btn-cta:hover::before{transform:translateX(100%)}
    .btn-cta:active{transform:translateY(0)}
    .btn-cta .arrow{transition:transform .25s ease}
    .btn-cta:hover .arrow{transform:translateX(4px)}

    .divider-or{
        display:flex;align-items:center;gap:1rem;margin:2rem 0 1.5rem;
        color:var(--muted-2);font-size:.78rem;letter-spacing:.18em;text-transform:uppercase;
    }
    .divider-or::before,.divider-or::after{content:"";flex:1;height:1px;background:var(--line-strong)}
    .signup-cta{text-align:center;color:var(--muted);font-size:.95rem}
    .signup-cta a{
        color:var(--ink);font-weight:600;text-decoration:none;
        border-bottom:1.5px solid var(--champagne);padding-bottom:1px;transition:all .2s ease;
    }
    .signup-cta a:hover{color:var(--champagne-dark);border-bottom-color:var(--ink)}

    @media (max-width:900px){
        .auth-shell{grid-template-columns:1fr;min-height:auto}
        .auth-brand{padding:3rem 2rem;min-height:300px}
        .brand-features{display:none}
        .auth-form-side{padding:2.5rem 1.25rem}
    }
</style>

<div class="auth-shell">
    <aside class="auth-brand">
        <div class="brand-mark">
            <span class="dot"></span>
            <span>{{ config('app.name') }} · Acceso seguro</span>
        </div>

        <div class="brand-hero">
            <h1>Bienvenido <br>de vuelta a tu <em>espacio</em>.</h1>
            <p>Accede para descubrir novedades, gestionar tus pedidos y vivir una experiencia cuidada al detalle.</p>
        </div>

        <div class="brand-features">
            <div class="brand-feature"><div class="num">10k+</div><div class="lbl">Artículos</div></div>
            <div class="brand-feature"><div class="num">24/7</div><div class="lbl">Soporte</div></div>
            <div class="brand-feature"><div class="num">100%</div><div class="lbl">Seguro</div></div>
        </div>
    </aside>

    <section class="auth-form-side">
        <div class="auth-card">
            <div class="eyebrow">Acceso · Cuenta</div>
            <h2>Iniciar sesión</h2>
            <p class="sub">Ingresa tus credenciales para continuar.</p>

            @if($errors->any())
                <div class="auth-alert">
                    @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
                </div>
            @endif

            <form action="{{ route('login.attempt') }}" method="POST" novalidate>
                @csrf

                <div class="field">
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder=" " required autofocus autocomplete="email">
                    <label for="email">Correo electrónico</label>
                    <span class="icon" aria-hidden="true">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/>
                        </svg>
                    </span>
                </div>

                <div class="field">
                    <input type="password" id="password" name="password" placeholder=" " required autocomplete="current-password">
                    <label for="password">Contraseña</label>
                    <span class="icon" aria-hidden="true">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="4" y="11" width="16" height="10" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/>
                        </svg>
                    </span>
                    <button type="button" class="toggle-pass" aria-label="Mostrar contraseña" onclick="(function(b){var i=document.getElementById('password');i.type=i.type==='password'?'text':'password';})(this)">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>

                <div class="row-extras">
                    <label class="check"><input type="checkbox" name="remember"><span>Recordarme</span></label>
                    <a href="#" class="forgot">¿Olvidaste tu contraseña?</a>
                </div>

                <button type="submit" class="btn-cta">
                    <span>Acceder a mi cuenta</span>
                    <svg class="arrow" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>
                    </svg>
                </button>
            </form>

            <div class="divider-or">o</div>

            <div class="signup-cta">
                ¿Aún no tienes cuenta? <a href="{{ route('register.form') }}">Crear cuenta nueva</a>
            </div>
        </div>
    </section>
</div>
@endsection
