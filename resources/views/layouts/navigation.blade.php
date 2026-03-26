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
                            @if (! Auth::user()->isCliente())
                                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                                    Panel
                                </x-nav-link>
                            @else
                                <x-nav-link :href="route('client.dashboard')" :active="request()->routeIs('client.dashboard')">
                                    Dashboard
                                </x-nav-link>
                            @endif

                            <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                                Inicio
                            </x-nav-link>

                            @if (Auth::user()->isCliente())
                                <x-nav-link :href="route('client.products.index')" :active="request()->routeIs('client.products.*')">
                                    Catalogo
                                </x-nav-link>
                                <x-nav-link :href="route('client.cart')" :active="request()->routeIs('client.cart')">
                                    Carrito
                                </x-nav-link>
                                <x-nav-link :href="route('client.orders.index')" :active="request()->routeIs('client.orders.*')">
                                    Pedidos
                                </x-nav-link>
                            @endif

                            @if (Auth::user()->isEmpleado() || Auth::user()->isGerente())
                                <x-nav-link :href="route('inventory.products.index')" :active="request()->routeIs('inventory.products.*')">
                                    Inventario
                                </x-nav-link>
                                <x-nav-link :href="route('employee.purchase-requests.index')" :active="request()->routeIs('employee.purchase-requests.*')">
                                    Solicitudes
                                </x-nav-link>
                            @endif

                            @if (Auth::user()->isGerente())
                                <x-nav-link :href="route('manager.users.index')" :active="request()->routeIs('manager.users.*')">
                                    Usuarios
                                </x-nav-link>
                                <x-nav-link :href="route('manager.content.edit')" :active="request()->routeIs('manager.content.*')">
                                    Contenido
                                </x-nav-link>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="hidden items-center gap-3 sm:flex">
                <span class="raph-pill">Mi cuenta</span>
                <x-dropdown align="right" width="64">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-3 rounded-full border border-white/80 bg-white/80 px-3 py-2 shadow-sm transition hover:border-slate-200 hover:bg-white">
                            <span class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-raph-green to-raph-green-dark text-sm font-semibold text-white">
                                {{ strtoupper(mb_substr(Auth::user()->name, 0, 1)) }}
                            </span>
                            <span class="hidden text-left md:block">
                                <span class="block text-sm font-semibold text-slate-900">{{ Auth::user()->name }}</span>
                                <span class="block text-xs text-slate-500">{{ Auth::user()->email }}</span>
                            </span>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-2 py-2">
                            <x-dropdown-link :href="route('profile.edit')">
                                Perfil
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                    Cerrar sesion
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
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
            @if (! Auth::user()->isCliente())
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    Panel
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('client.dashboard')" :active="request()->routeIs('client.dashboard')">
                    Dashboard
                </x-responsive-nav-link>
            @endif

            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                Inicio
            </x-responsive-nav-link>

            @if (Auth::user()->isCliente())
                <x-responsive-nav-link :href="route('client.products.index')" :active="request()->routeIs('client.products.*')">
                    Catalogo
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('client.cart')" :active="request()->routeIs('client.cart')">
                    Carrito
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('client.orders.index')" :active="request()->routeIs('client.orders.*')">
                    Pedidos
                </x-responsive-nav-link>
            @endif

            @if (Auth::user()->isEmpleado() || Auth::user()->isGerente())
                <x-responsive-nav-link :href="route('inventory.products.index')" :active="request()->routeIs('inventory.products.*')">
                    Inventario
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('employee.purchase-requests.index')" :active="request()->routeIs('employee.purchase-requests.*')">
                    Solicitudes
                </x-responsive-nav-link>
            @endif

            @if (Auth::user()->isGerente())
                <x-responsive-nav-link :href="route('manager.users.index')" :active="request()->routeIs('manager.users.*')">
                    Usuarios
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('manager.content.edit')" :active="request()->routeIs('manager.content.*')">
                    Contenido
                </x-responsive-nav-link>
            @endif
        </div>

        <div class="mt-4 rounded-[28px] border border-white/80 bg-white/80 p-4 shadow-sm">
            <div class="text-sm font-semibold text-slate-900">{{ Auth::user()->name }}</div>
            <div class="mt-1 text-sm text-slate-500">{{ Auth::user()->email }}</div>

            <div class="mt-4 space-y-2">
                <x-responsive-nav-link :href="route('profile.edit')">
                    Perfil
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                        Cerrar sesion
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
