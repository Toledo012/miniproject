<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">

    <style>
        /* ============ TOKENS ============ */
        :root{
            --bg:#f7f3ec;
            --surface:#ffffff;
            --surface-2:#fbf8f1;
            --ink:#0a0a0a;
            --carbon:#1c1c1c;
            --line:#e8e2d4;
            --line-strong:#d9d2c4;
            --muted:#6b6660;
            --muted-2:#9a9489;
            --cream:#efe7d8;
            --champagne:#c9a876;
            --champagne-dark:#a8895d;
            --ok-bg:#e8eee3;
            --ok-ink:#2d4a2b;
            --warn-bg:#f4ecd6;
            --warn-ink:#8a6d2a;
            --bad-bg:#f1dcdc;
            --bad-ink:#7a2a2a;
            --shadow-sm:0 1px 2px rgba(20,15,5,.04), 0 1px 1px rgba(20,15,5,.03);
            --shadow-md:0 6px 24px -8px rgba(20,15,5,.12), 0 2px 6px rgba(20,15,5,.05);
            --shadow-lg:0 24px 48px -16px rgba(20,15,5,.18);
            --radius:10px;
            --radius-lg:14px;
        }

        /* ============ RESET / BASE ============ */
        *{box-sizing:border-box}
        html,body{margin:0;padding:0}
        body{
            font-family:'Inter',system-ui,-apple-system,sans-serif;
            background:var(--bg);
            color:var(--ink);
            font-size:15px;
            line-height:1.55;
            -webkit-font-smoothing:antialiased;
            text-rendering:optimizeLegibility;
        }
        h1,h2,h3,h4{
            font-family:'Playfair Display',Georgia,serif;
            font-weight:600;
            letter-spacing:-.015em;
            color:var(--ink);
            margin:0 0 .75rem;
            line-height:1.15;
        }
        h1{font-size:2rem}
        h2{font-size:1.4rem;font-weight:600}
        h3{font-size:1.1rem}
        a{color:var(--ink);text-decoration:none}
        a:hover{color:var(--champagne-dark)}
        p{margin:0 0 .75rem}
        code{
            font-family:'JetBrains Mono',ui-monospace,monospace;
            background:var(--cream);padding:.1rem .4rem;border-radius:4px;font-size:.85em;
        }

        /* ============ NAV ============ */
        nav.topbar{
            background:var(--ink);
            color:#f5f0e8;
            padding:0 2rem;
            display:flex;justify-content:space-between;align-items:center;
            height:64px;
            position:sticky;top:0;z-index:50;
            border-bottom:1px solid rgba(201,168,118,.18);
            box-shadow:0 1px 0 rgba(0,0,0,.5);
        }
        nav.topbar .nav-left{display:flex;align-items:center;gap:2rem}
        nav.topbar .brand{
            font-family:'Playfair Display',serif;
            font-weight:700;font-size:1.35rem;
            letter-spacing:.02em;
            color:#f5f0e8;
            display:flex;align-items:center;gap:.55rem;
        }
        nav.topbar .brand::before{
            content:"";
            width:8px;height:8px;border-radius:50%;
            background:var(--champagne);
            box-shadow:0 0 10px var(--champagne);
        }
        nav.topbar .nav-links{display:flex;gap:.25rem;align-items:center;flex-wrap:wrap}
        nav.topbar .nav-links a{
            color:#cfc8bb;
            padding:.45rem .85rem;border-radius:6px;
            font-size:.9rem;font-weight:500;
            transition:all .2s ease;
            position:relative;
        }
        nav.topbar .nav-links a:hover{color:#fff;background:rgba(255,255,255,.06)}
        nav.topbar .nav-right{display:flex;align-items:center;gap:1rem}
        nav.topbar .user-chip{
            display:flex;align-items:center;gap:.6rem;
            padding:.35rem .85rem .35rem .35rem;
            background:rgba(255,255,255,.05);
            border:1px solid rgba(201,168,118,.18);
            border-radius:999px;
            font-size:.85rem;color:#e8e2d4;
        }
        nav.topbar .user-chip .avatar{
            width:28px;height:28px;border-radius:50%;
            background:linear-gradient(135deg,var(--champagne),var(--champagne-dark));
            color:var(--ink);font-weight:600;font-size:.8rem;
            display:flex;align-items:center;justify-content:center;
        }
        nav.topbar .user-chip .role{
            font-size:.7rem;color:var(--champagne);
            text-transform:uppercase;letter-spacing:.1em;
        }
        nav.topbar .btn-logout{
            background:transparent;border:1px solid rgba(255,255,255,.18);
            color:#e8e2d4;padding:.45rem .85rem;border-radius:6px;
            font-size:.85rem;cursor:pointer;font-family:inherit;
            transition:all .2s ease;
        }
        nav.topbar .btn-logout:hover{background:rgba(255,255,255,.08);border-color:var(--champagne)}
        nav.topbar .btn-nav-cta{
            background:var(--champagne);color:var(--ink);
            padding:.5rem 1rem;border-radius:6px;font-weight:600;
            font-size:.85rem;letter-spacing:.02em;
            transition:all .2s ease;
        }
        nav.topbar .btn-nav-cta:hover{background:#e8c896;color:var(--ink)}

        /* ============ CONTAINER ============ */
        .container{max-width:1180px;margin:2.5rem auto;padding:0 1.5rem}
        .container:has(.login-shell),
        .container:has(.auth-shell){max-width:none;margin:0;padding:0}

        /* ============ CARD ============ */
        .card{
            background:var(--surface);
            border:1px solid var(--line);
            border-radius:var(--radius-lg);
            padding:1.75rem;
            box-shadow:var(--shadow-sm);
            margin-bottom:1.25rem;
        }
        .card h1:first-child,.card h2:first-child{margin-top:0}

        /* Page header (título + acción) */
        .page-header{
            display:flex;justify-content:space-between;align-items:flex-end;
            gap:1rem;margin-bottom:1.5rem;padding-bottom:1.5rem;
            border-bottom:1px solid var(--line);
        }
        .page-header .eyebrow{
            font-size:.7rem;letter-spacing:.3em;text-transform:uppercase;
            color:var(--champagne-dark);font-weight:600;margin-bottom:.4rem;
        }
        .page-header h1{margin:0}
        .page-header p{color:var(--muted);margin:.4rem 0 0;font-size:.95rem}

        /* ============ FORM ELEMENTS ============ */
        label{
            display:block;margin-bottom:.4rem;
            font-weight:500;font-size:.85rem;
            color:var(--ink);letter-spacing:.01em;
        }
        label small{font-weight:400;color:var(--muted)}
        input[type=text],input[type=email],input[type=password],input[type=number],
        input[type=file],select,textarea{
            width:100%;
            padding:.75rem .9rem;
            border:1.5px solid var(--line-strong);
            background:var(--surface);
            border-radius:var(--radius);
            margin-bottom:1rem;
            font-family:inherit;font-size:.95rem;
            color:var(--ink);
            transition:border-color .2s ease, box-shadow .2s ease, background .2s ease;
        }
        input:hover,select:hover,textarea:hover{border-color:#b8ad97}
        input:focus,select:focus,textarea:focus{
            outline:none;border-color:var(--ink);
            box-shadow:0 0 0 4px rgba(10,10,10,.06);
        }
        textarea{resize:vertical;min-height:100px}
        input[type=file]{padding:.55rem .6rem;background:var(--surface-2)}
        input[type=file]::file-selector-button{
            background:var(--ink);color:#fff;border:0;padding:.45rem .9rem;
            border-radius:6px;margin-right:.75rem;cursor:pointer;font-family:inherit;
            font-size:.85rem;font-weight:500;
        }
        input[type=file]::file-selector-button:hover{background:var(--carbon)}

        /* ============ BUTTONS ============ */
        button,.btn{
            background:var(--ink);color:#f7f3ec;
            border:1.5px solid var(--ink);
            padding:.7rem 1.4rem;border-radius:var(--radius);
            cursor:pointer;font-size:.9rem;font-weight:600;
            letter-spacing:.02em;
            text-decoration:none;display:inline-block;
            font-family:inherit;
            transition:all .2s ease;
            box-shadow:var(--shadow-sm);
        }
        button:hover,.btn:hover{
            background:var(--carbon);color:#fff;
            transform:translateY(-1px);
            box-shadow:var(--shadow-md);
        }
        button:active,.btn:active{transform:translateY(0)}
        .btn-secondary{
            background:transparent;color:var(--ink);
            border-color:var(--line-strong);
        }
        .btn-secondary:hover{
            background:var(--cream);color:var(--ink);
            border-color:var(--ink);
        }
        .btn-danger{
            background:var(--bad-ink);color:#fff;border-color:var(--bad-ink);
        }
        .btn-danger:hover{background:#5a1f1f;border-color:#5a1f1f;color:#fff}
        .btn-ghost{
            background:transparent;color:var(--muted);border-color:transparent;
            box-shadow:none;
        }
        .btn-ghost:hover{background:var(--cream);color:var(--ink);box-shadow:none;transform:none}
        .btn-sm{padding:.4rem .8rem;font-size:.8rem}
        .btn-block{display:block;width:100%;text-align:center}

        /* ============ ALERTS ============ */
        .alert{
            padding:.85rem 1.1rem;border-radius:var(--radius);
            margin-bottom:1.25rem;font-size:.9rem;
            display:flex;align-items:flex-start;gap:.65rem;
            border-left:3px solid currentColor;
        }
        .alert-success{background:var(--ok-bg);color:var(--ok-ink)}
        .alert-error{background:var(--bad-bg);color:var(--bad-ink)}
        .alert div+div{margin-top:.25rem}

        /* ============ TABLES ============ */
        .table-wrap{overflow-x:auto;margin:0 -.25rem}
        table{
            width:100%;border-collapse:separate;border-spacing:0;
            font-size:.9rem;
        }
        thead th{
            background:var(--surface-2);
            text-align:left;font-weight:600;font-size:.72rem;
            text-transform:uppercase;letter-spacing:.1em;
            color:var(--muted);
            padding:.85rem 1rem;
            border-bottom:1.5px solid var(--line-strong);
        }
        thead th:first-child{border-top-left-radius:var(--radius)}
        thead th:last-child{border-top-right-radius:var(--radius)}
        tbody td{
            padding:.95rem 1rem;
            border-bottom:1px solid var(--line);
            color:var(--ink);
            vertical-align:middle;
        }
        tbody tr:hover td{background:var(--surface-2)}
        tbody tr:last-child td{border-bottom:0}
        td .btn,td button{margin-right:.25rem}

        /* ============ BADGES ============ */
        .badge{
            display:inline-flex;align-items:center;gap:.35rem;
            padding:.25rem .6rem;border-radius:999px;
            font-size:.72rem;font-weight:600;
            text-transform:uppercase;letter-spacing:.08em;
            border:1px solid transparent;
        }
        .badge::before{
            content:"";width:6px;height:6px;border-radius:50%;background:currentColor;
        }
        .badge-pendiente{background:var(--warn-bg);color:var(--warn-ink);border-color:#e6d8a8}
        .badge-validada{background:var(--ok-bg);color:var(--ok-ink);border-color:#cbd9bf}
        .badge-rechazada{background:var(--bad-bg);color:var(--bad-ink);border-color:#e3c1c1}
        .badge-soft{background:var(--cream);color:var(--ink);border-color:var(--line-strong)}
        .badge-soft::before{display:none}

        /* ============ GRID / PRODUCT CARDS ============ */
        .grid-cards{
            display:grid;
            grid-template-columns:repeat(auto-fill,minmax(260px,1fr));
            gap:1.25rem;
        }
        .product-card{
            background:var(--surface);
            border:1px solid var(--line);
            border-radius:var(--radius-lg);
            overflow:hidden;
            display:flex;flex-direction:column;
            transition:transform .25s ease, box-shadow .25s ease, border-color .25s ease;
        }
        .product-card:hover{
            transform:translateY(-4px);
            box-shadow:var(--shadow-md);
            border-color:var(--line-strong);
        }
        .product-card .ph-img{
            width:100%;aspect-ratio:1/1;object-fit:cover;display:block;
            background:var(--cream);
        }
        .product-card .ph-empty{
            width:100%;aspect-ratio:1/1;
            background:linear-gradient(135deg,var(--cream),var(--surface-2));
            display:flex;align-items:center;justify-content:center;
            color:var(--muted-2);font-size:.85rem;letter-spacing:.1em;text-transform:uppercase;
        }
        .product-card .body{padding:1rem 1.1rem 1.1rem;display:flex;flex-direction:column;gap:.4rem;flex:1}
        .product-card .name{
            font-family:'Playfair Display',serif;font-weight:600;font-size:1.05rem;
            color:var(--ink);line-height:1.25;
        }
        .product-card .price{
            font-size:1.15rem;font-weight:600;color:var(--ink);
            letter-spacing:-.01em;
            display:flex;align-items:baseline;gap:.35rem;
        }
        .product-card .price::before{content:"$";color:var(--champagne-dark);font-size:.85rem}
        .product-card .meta{font-size:.78rem;color:var(--muted);display:flex;flex-wrap:wrap;gap:.35rem;align-items:center}
        .product-card .cats{display:flex;flex-wrap:wrap;gap:.3rem;margin-top:.15rem}
        .product-card .actions{display:flex;gap:.4rem;flex-wrap:wrap;margin-top:auto;padding-top:.6rem}

        /* ============ FILTER BAR ============ */
        .filter-bar{
            display:flex;flex-wrap:wrap;gap:.75rem;align-items:flex-end;
        }
        .filter-bar > div{flex:1;min-width:180px}
        .filter-bar input,.filter-bar select{margin-bottom:0}

        /* ============ TABS / SEGMENTED ============ */
        .seg{
            display:inline-flex;background:var(--cream);
            padding:.3rem;border-radius:999px;gap:.15rem;
            border:1px solid var(--line-strong);
        }
        .seg a{
            padding:.45rem 1rem;border-radius:999px;
            font-size:.82rem;font-weight:500;color:var(--muted);
            transition:all .2s ease;
        }
        .seg a:hover{color:var(--ink)}
        .seg a.active{background:var(--ink);color:#f7f3ec}

        /* ============ STAT / DEFINITION ============ */
        .stat-grid{
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(180px,1fr));
            gap:1rem;
        }
        .stat{
            background:var(--surface);
            border:1px solid var(--line);
            border-radius:var(--radius-lg);
            padding:1.25rem;
        }
        .stat .lbl{
            font-size:.7rem;letter-spacing:.2em;text-transform:uppercase;
            color:var(--muted);font-weight:600;
        }
        .stat .num{
            font-family:'Playfair Display',serif;font-weight:600;
            font-size:2.25rem;color:var(--ink);
            margin-top:.4rem;letter-spacing:-.02em;line-height:1;
        }
        .stat .sub{font-size:.78rem;color:var(--muted);margin-top:.25rem}

        /* ============ FORM HELPERS ============ */
        form.inline{display:inline}
        .form-row{display:grid;grid-template-columns:1fr 1fr;gap:1rem}
        .chip-group{display:flex;flex-wrap:wrap;gap:.5rem;margin-bottom:1rem}
        .chip{
            background:var(--surface);border:1.5px solid var(--line-strong);
            padding:.5rem .85rem;border-radius:999px;cursor:pointer;
            font-size:.85rem;font-weight:500;color:var(--ink);
            transition:all .2s ease;display:inline-flex;align-items:center;gap:.4rem;
        }
        .chip:hover{border-color:var(--ink);background:var(--cream)}
        .chip input{width:auto;margin:0;accent-color:var(--ink)}
        .chip:has(input:checked){background:var(--ink);color:#f7f3ec;border-color:var(--ink)}

        .radio-card{
            flex:1;min-width:160px;
            border:1.5px solid var(--line-strong);
            border-radius:var(--radius);padding:1rem;
            cursor:pointer;font-weight:400;
            display:flex;gap:.65rem;align-items:flex-start;
            transition:all .2s ease;background:var(--surface);
        }
        .radio-card:hover{border-color:var(--ink)}
        .radio-card:has(input:checked){border-color:var(--ink);background:var(--cream);box-shadow:0 0 0 3px rgba(10,10,10,.04)}
        .radio-card input{width:auto;margin:.2rem 0 0;accent-color:var(--ink)}
        .radio-card strong{font-family:'Playfair Display',serif;font-size:1rem}
        .radio-card small{display:block;color:var(--muted);font-size:.8rem;margin-top:.15rem}

        /* ============ PAGINATION ============ */
        .pagination{display:flex;gap:.25rem;list-style:none;padding:0;margin:1.25rem 0 0;flex-wrap:wrap}
        .pagination li a,.pagination li span{
            display:inline-flex;align-items:center;justify-content:center;
            min-width:36px;height:36px;padding:0 .65rem;
            border:1px solid var(--line-strong);border-radius:8px;
            background:var(--surface);color:var(--ink);font-size:.85rem;
            text-decoration:none;
        }
        .pagination li.active span{background:var(--ink);color:#f7f3ec;border-color:var(--ink)}
        .pagination li.disabled span{color:var(--muted-2);background:transparent;border-color:var(--line)}
        .pagination li a:hover{background:var(--cream);border-color:var(--ink)}

        /* ============ MISC ============ */
        .muted{color:var(--muted)}
        .divider{height:1px;background:var(--line);margin:1.25rem 0;border:0}
        .stack{display:flex;flex-direction:column;gap:1rem}
        .row{display:flex;gap:.5rem;flex-wrap:wrap}
        .row-between{display:flex;justify-content:space-between;align-items:center;gap:1rem;flex-wrap:wrap}

        @media (max-width:720px){
            nav.topbar{padding:0 1rem;height:auto;flex-wrap:wrap;gap:.75rem;padding-top:.75rem;padding-bottom:.75rem}
            nav.topbar .nav-left{flex-wrap:wrap;gap:.75rem;width:100%}
            nav.topbar .nav-right{width:100%;justify-content:flex-end}
            .container{margin:1.5rem auto;padding:0 1rem}
            h1{font-size:1.6rem}
            .card{padding:1.25rem}
            .form-row{grid-template-columns:1fr}
            .page-header{flex-direction:column;align-items:flex-start}
        }
    </style>
</head>
<body>
    <nav class="topbar">
        <div class="nav-left">
            <a href="{{ route('catalogo') }}" class="brand">{{ config('app.name') }}</a>
            <div class="nav-links">
            @auth
                @php($u = auth()->user())
                @if($u->esAdmin())
                    <a href="{{ route('dashboard') }}">Panel</a>
                    <a href="{{ route('users.index') }}">Usuarios</a>
                    <a href="{{ route('productos.index') }}">Productos</a>
                    <a href="{{ route('categorias.index') }}">Categorías</a>
                    <a href="{{ route('ventas.index') }}">Ventas</a>
                @elseif($u->esGerente())
                    <a href="{{ route('productos.index') }}">Productos</a>
                    <a href="{{ route('categorias.index') }}">Categorías</a>
                    <a href="{{ route('ventas.index') }}">Ventas</a>
                @elseif($u->esVendedor())
                    <a href="{{ route('productos.index') }}">Mis productos</a>
                    <a href="{{ route('ventas.index') }}">Mis ventas</a>
                @else
                    <a href="{{ route('catalogo') }}">Catálogo</a>
                    <a href="{{ route('ventas.index') }}">Mis compras</a>
                @endif
            @else
                <a href="{{ route('catalogo') }}">Catálogo</a>
            @endauth
            </div>
        </div>
        <div class="nav-right">
            @auth
                <div class="user-chip">
                    <div class="avatar">{{ strtoupper(mb_substr(auth()->user()->nombre, 0, 1)) }}</div>
                    <div>
                        <div>{{ auth()->user()->nombre }}</div>
                        <div class="role">{{ auth()->user()->rol }}</div>
                    </div>
                </div>
                <form class="inline" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-logout">Salir</button>
                </form>
            @else
                <a href="{{ route('login') }}" style="color:#cfc8bb;font-size:.9rem">Iniciar sesión</a>
                <a class="btn-nav-cta" href="{{ route('register.form') }}">Crear cuenta</a>
            @endauth
        </div>
    </nav>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success"><div>{{ session('success') }}</div></div>
        @endif
        @if(session('error'))
            <div class="alert alert-error"><div>{{ session('error') }}</div></div>
        @endif

        @yield('content')
    </div>
</body>
</html>
