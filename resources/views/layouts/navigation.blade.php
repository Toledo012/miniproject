<nav x-data="{ open: false }" class="relative z-20 border-b border-white/60 bg-white/55 backdrop-blur-2xl">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-20 items-center justify-between gap-6">
            <div class="flex min-w-0 items-center gap-4">
                <a href="{{ route('home') }}" class="flex items-center gap-3 transition hover:opacity-90">
                    <x-application-logo class="h-11 w-auto" />
                </a>

                <div class="hidden xl:flex">
                    <div class="rounded-full border border-white/80 bg-white/70 p-1 shadow-sm">
                        <div class="flex items-center gap-1">
                            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard') || request()->routeIs('panel.*')">
                                Panel
                            </x-nav-link>
                            <x-nav-link :href="route('productos.index')" :active="request()->routeIs('productos.*')">
                                Productos
                            </x-nav-link>
                            <x-nav-link :href="route('categorias.index')" :active="request()->routeIs('categorias.*')">
                                Categorias
                            </x-nav-link>
                            <x-nav-link :href="route('ventas.index')" :active="request()->routeIs('ventas.*')">
                                Ventas
                            </x-nav-link>
                            @if (auth()->user()->esAdministrador() || auth()->user()->esGerente())
                                <x-nav-link :href="route('usuarios.index')" :active="request()->routeIs('usuarios.*')">
                                    Usuarios
                                </x-nav-link>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="hidden items-center gap-3 sm:flex">
                <span class="raph-pill">{{ ucfirst(auth()->user()->rol) }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="raph-button-secondary">Cerrar sesion</button>
                </form>
            </div>

            <button @click="open = ! open" class="inline-flex h-12 w-12 items-center justify-center rounded-full border border-white/80 bg-white/80 text-slate-700 shadow-sm transition hover:bg-white sm:hidden">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 7h16M4 12h16M4 17h16" />
                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden border-t border-white/70 bg-white/75 px-4 py-4 backdrop-blur-2xl sm:hidden">
        <div class="space-y-2">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard') || request()->routeIs('panel.*')">
                Panel
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('productos.index')" :active="request()->routeIs('productos.*')">
                Productos
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('categorias.index')" :active="request()->routeIs('categorias.*')">
                Categorias
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('ventas.index')" :active="request()->routeIs('ventas.*')">
                Ventas
            </x-responsive-nav-link>
            @if (auth()->user()->esAdministrador() || auth()->user()->esGerente())
                <x-responsive-nav-link :href="route('usuarios.index')" :active="request()->routeIs('usuarios.*')">
                    Usuarios
                </x-responsive-nav-link>
            @endif
        </div>

        <div class="mt-4 rounded-[28px] border border-white/80 bg-white/80 p-4 shadow-sm">
            <div class="text-sm font-semibold text-slate-900">{{ auth()->user()->nombre }} {{ auth()->user()->apellidos }}</div>
            <div class="mt-1 text-sm text-slate-500">{{ auth()->user()->correo }}</div>
            <div class="mt-1 text-xs uppercase tracking-[0.2em] text-slate-400">{{ auth()->user()->rol }}</div>

            <form method="POST" action="{{ route('logout') }}" class="mt-4">
                @csrf
                <button type="submit" class="raph-button-secondary w-full">Cerrar sesion</button>
            </form>
        </div>
    </div>
</nav>
