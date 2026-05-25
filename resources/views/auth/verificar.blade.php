@extends('layouts.app')

@section('title', 'Verificar código')

@section('content')
<style>
    .verify-wrap{
        min-height:calc(100vh - 64px);background:var(--bg);
        display:flex;align-items:center;justify-content:center;padding:2rem 1rem;
        position:relative;overflow:hidden;
    }
    .verify-wrap::before{
        content:"";position:absolute;top:-200px;left:-200px;width:500px;height:500px;border-radius:50%;
        background:radial-gradient(circle,var(--cream),transparent 70%);opacity:.7;
    }
    .verify-wrap::after{
        content:"";position:absolute;bottom:-200px;right:-200px;width:500px;height:500px;border-radius:50%;
        background:radial-gradient(circle,rgba(201,168,118,.18),transparent 70%);
    }
    .verify-card{
        position:relative;z-index:1;
        background:#fff;border:1px solid var(--line);
        border-radius:18px;padding:3rem 2.5rem;
        max-width:460px;width:100%;
        box-shadow:var(--shadow-lg);
        text-align:center;
    }
    .verify-card .seal{
        width:72px;height:72px;margin:0 auto 1.5rem;border-radius:50%;
        background:linear-gradient(135deg,var(--ink),var(--carbon));
        display:flex;align-items:center;justify-content:center;color:var(--champagne);
        box-shadow:0 8px 24px rgba(10,10,10,.2);
        position:relative;
    }
    .verify-card .seal::after{
        content:"";position:absolute;inset:-6px;border-radius:50%;
        border:1.5px solid var(--champagne);opacity:.35;
    }
    .verify-card .eyebrow{
        font-size:.7rem;letter-spacing:.3em;text-transform:uppercase;
        color:var(--champagne-dark);font-weight:600;margin-bottom:.6rem;
    }
    .verify-card h2{
        font-family:'Playfair Display',serif;font-size:1.85rem;font-weight:600;
        margin:0 0 .6rem;color:var(--ink);
    }
    .verify-card .sub{color:var(--muted);font-size:.95rem;margin-bottom:.4rem}
    .verify-card .timer{
        display:inline-flex;align-items:center;gap:.45rem;
        font-size:.78rem;color:var(--warn-ink);background:var(--warn-bg);
        padding:.35rem .8rem;border-radius:999px;font-weight:600;
        margin:.5rem 0 1.75rem;border:1px solid #e6d8a8;
    }
    .verify-alert{
        background:var(--bad-bg);color:var(--bad-ink);
        border-left:3px solid var(--bad-ink);
        padding:.85rem 1rem;margin-bottom:1.25rem;border-radius:0 8px 8px 0;
        text-align:left;font-size:.88rem;
    }
    .code-input{
        width:100%;padding:1.15rem 1rem;text-align:center;
        font-family:'JetBrains Mono','Courier New',monospace;
        font-size:2rem;letter-spacing:.75rem;font-weight:600;
        border:1.5px solid var(--line-strong);background:var(--surface-2);
        border-radius:12px;color:var(--ink);
        transition:all .25s ease;margin-bottom:1.5rem;
    }
    .code-input:focus{outline:none;border-color:var(--ink);box-shadow:0 0 0 4px rgba(10,10,10,.06);background:#fff}
    .btn-verify{
        width:100%;background:var(--ink);color:var(--bg);
        border:0;padding:1.05rem 1.5rem;border-radius:12px;
        font-size:.9rem;font-weight:600;letter-spacing:.05em;text-transform:uppercase;
        cursor:pointer;display:flex;align-items:center;justify-content:center;gap:.6rem;
        box-shadow:0 4px 14px rgba(0,0,0,.15);transition:all .2s ease;
    }
    .btn-verify:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(0,0,0,.25)}
    .verify-foot{margin-top:1.5rem;color:var(--muted);font-size:.85rem}
</style>

<div class="verify-wrap">
    <div class="verify-card">
        <div class="seal">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
        </div>

        <div class="eyebrow">Verificación · 2 pasos</div>
        <h2>Confirma tu identidad</h2>
        <p class="sub">Ingresa el código de 6 dígitos que enviamos a tu correo.</p>
        <div class="timer">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            Expira en 5 minutos
        </div>

        @if($errors->any())
            <div class="verify-alert">
                @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
            </div>
        @endif

        <form action="{{ route('verificar.attempt') }}" method="POST">
            @csrf
            <input class="code-input" type="text" id="codigo" name="codigo" inputmode="numeric" maxlength="6" pattern="[0-9]{6}" required autofocus autocomplete="one-time-code" placeholder="······">
            <button type="submit" class="btn-verify">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                Verificar y continuar
            </button>
        </form>

        <div class="verify-foot">¿No recibiste el código? Revisa tu carpeta de spam.</div>
    </div>
</div>
@endsection
