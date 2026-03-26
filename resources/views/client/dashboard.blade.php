<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-raph-green">RAPH</p>
                <h1 class="text-3xl font-semibold tracking-tight text-slate-950">Tu espacio de compra</h1>
                <p class="max-w-2xl text-sm text-slate-600">Consulta tu actividad, completa tu perfil y entra rapido a las acciones que mas usas.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('client.products.index') }}" class="raph-button-primary">Explorar catalogo</a>
                <a href="{{ route('client.cart') }}" class="raph-button-secondary">Ver carrito</a>
            </div>
        </div>
    </x-slot>

    <div class="page-section">
        <div class="mx-auto grid max-w-7xl gap-6">
            <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                <article class="glass-card p-6">
                    <p class="text-sm text-slate-500">Productos en carrito</p>
                    <p class="mt-3 text-4xl font-semibold tracking-tight text-slate-950">{{ $cartCount }}</p>
                    <p class="mt-2 text-sm text-slate-500">Monto estimado: ${{ number_format($cartTotal, 2) }}</p>
                </article>
                <article class="glass-card p-6">
                    <p class="text-sm text-slate-500">Pedidos pendientes</p>
                    <p class="mt-3 text-4xl font-semibold tracking-tight text-slate-950">{{ $pendingOrders }}</p>
                    <p class="mt-2 text-sm text-slate-500">Seguimiento de compras recientes</p>
                </article>
                <article class="glass-card p-6">
                    <p class="text-sm text-slate-500">Pedidos entregados</p>
                    <p class="mt-3 text-4xl font-semibold tracking-tight text-slate-950">{{ $deliveredOrders }}</p>
                    <p class="mt-2 text-sm text-slate-500">Historial completado</p>
                </article>
                <article class="glass-card p-6">
                    <p class="text-sm text-slate-500">Perfil listo para comprar</p>
                    <p class="mt-3 text-4xl font-semibold tracking-tight text-slate-950">{{ $profileProgress }}%</p>
                    <div class="mt-4 h-2 rounded-full bg-slate-200">
                        <div class="h-2 rounded-full bg-gradient-to-r from-raph-green to-raph-green-dark" style="width: {{ $profileProgress }}%"></div>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="mt-4 inline-flex text-sm font-medium text-raph-green-dark transition hover:text-raph-green">Completar perfil</a>
                </article>
            </section>

            <section class="grid gap-6 xl:grid-cols-[1.1fr_0.9fr]">
                <div class="glass-card p-6 sm:p-8">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-raph-green">Acciones</p>
                            <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950">Todo lo importante, a un paso</h2>
                        </div>
                    </div>
                    <div class="mt-6 grid gap-4 md:grid-cols-2">
                        <a href="{{ route('client.products.index') }}" class="rounded-[28px] border border-white/80 bg-white/80 p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-xl">
                            <p class="text-lg font-semibold text-slate-900">Catalogo</p>
                            <p class="mt-2 text-sm text-slate-500">Busca productos, revisa precios y agrega articulos al carrito.</p>
                        </a>
                        <a href="{{ route('client.orders.index') }}" class="rounded-[28px] border border-white/80 bg-white/80 p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-xl">
                            <p class="text-lg font-semibold text-slate-900">Mis pedidos</p>
                            <p class="mt-2 text-sm text-slate-500">Consulta estados, fechas y detalles de tus compras.</p>
                        </a>
                        <a href="{{ route('client.cart') }}" class="rounded-[28px] border border-white/80 bg-white/80 p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-xl">
                            <p class="text-lg font-semibold text-slate-900">Carrito</p>
                            <p class="mt-2 text-sm text-slate-500">Ajusta cantidades antes de realizar el pago.</p>
                        </a>
                        <a href="{{ route('profile.edit') }}" class="rounded-[28px] border border-white/80 bg-white/80 p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-xl">
                            <p class="text-lg font-semibold text-slate-900">Perfil y direccion</p>
                            <p class="mt-2 text-sm text-slate-500">Mantén tu informacion lista para que el checkout sea fluido.</p>
                        </a>
                    </div>
                </div>

                <div class="glass-card p-6 sm:p-8">
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-raph-green">Pedidos recientes</p>
                    <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950">Ultima actividad</h2>
                    <div class="mt-6 space-y-4">
                        @forelse ($latestOrders as $order)
                            <article class="rounded-[26px] border border-white/80 bg-white/85 p-5 shadow-sm">
                                <div class="flex items-center justify-between gap-4">
                                    <div>
                                        <p class="font-semibold text-slate-900">Pedido #{{ $order->id }}</p>
                                        <p class="mt-1 text-sm text-slate-500">{{ $order->created_at?->format('d/m/Y H:i') }}</p>
                                    </div>
                                    <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $order->status === 'pendiente' ? 'bg-amber-100 text-amber-700' : 'bg-emerald-100 text-emerald-700' }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                                <p class="mt-3 text-sm text-slate-600">Total: ${{ number_format((float) $order->total, 2) }}</p>
                            </article>
                        @empty
                            <p class="rounded-[26px] border border-dashed border-slate-300 bg-white/70 px-5 py-8 text-sm text-slate-500">Todavia no hay pedidos. Cuando completes una compra apareceran aqui.</p>
                        @endforelse
                    </div>
                </div>
            </section>

            <section class="glass-card p-6 sm:p-8">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-raph-green">Destacados</p>
                        <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950">Sigue comprando en RAPH</h2>
                    </div>
                    <a href="{{ route('client.products.index') }}" class="text-sm font-medium text-raph-green-dark transition hover:text-raph-green">Ver todo el catalogo</a>
                </div>

                <div class="mt-6 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                    @foreach ($featuredProducts as $product)
                        <article class="rounded-[28px] border border-white/80 bg-white/85 p-4 shadow-sm">
                            <div class="flex h-44 items-center justify-center overflow-hidden rounded-[22px] bg-slate-100">
                                @if ($product->image_url)
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-full w-full object-contain">
                                @else
                                    <span class="text-sm text-slate-400">Sin imagen</span>
                                @endif
                            </div>
                            <h3 class="mt-4 text-lg font-semibold text-slate-900">{{ $product->name }}</h3>
                            <p class="mt-2 text-sm text-slate-500">{{ \Illuminate\Support\Str::limit($product->description ?: 'Producto disponible en la tienda.', 82) }}</p>
                            <div class="mt-4 flex items-center justify-between gap-3">
                                <span class="text-base font-semibold text-slate-950">${{ number_format((float) $product->price, 2) }}</span>
                                <a href="{{ route('client.products.show', $product) }}" class="text-sm font-medium text-raph-green-dark transition hover:text-raph-green">Ver detalle</a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
