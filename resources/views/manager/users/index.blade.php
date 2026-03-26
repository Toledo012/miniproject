<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-raph-green">RAPH</p>
                <h1 class="mt-2 text-3xl font-semibold tracking-tight text-slate-950">Gestion de usuarios</h1>
                <p class="mt-2 max-w-2xl text-sm text-slate-600">Gestiona cuentas, accesos y datos clave desde una vista centralizada.</p>
            </div>
            <a href="{{ route('manager.users.create') }}" class="raph-button-primary">Crear usuario</a>
        </div>
    </x-slot>

    <div class="page-section">
        <div class="mx-auto max-w-7xl space-y-6">
            @if (session('status'))
                <div class="rounded-3xl border border-emerald-200 bg-emerald-50/90 px-5 py-4 text-sm text-emerald-700 shadow-sm">
                    {{ session('status') }}
                </div>
            @endif

            @php
                $sections = [
                    ['title' => 'Gerentes', 'users' => $managers, 'tone' => 'from-slate-950 to-slate-700'],
                    ['title' => 'Empleados', 'users' => $employees, 'tone' => 'from-raph-dark to-raph-green-dark'],
                    ['title' => 'Clientes', 'users' => $clients, 'tone' => 'from-raph-green-dark to-raph-green'],
                ];
            @endphp

            @foreach ($sections as $section)
                <section class="glass-card overflow-hidden">
                    <div class="border-b border-white/70 px-6 py-5">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h2 class="text-xl font-semibold text-slate-950">{{ $section['title'] }}</h2>
                                <p class="text-sm text-slate-500">{{ $section['users']->total() }} registros en esta categoria</p>
                            </div>
                            <span class="inline-flex w-fit rounded-full bg-gradient-to-r {{ $section['tone'] }} px-3 py-1 text-xs font-semibold uppercase tracking-[0.24em] text-white">
                                {{ $section['title'] }}
                            </span>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left">
                            <thead class="bg-white/60 text-xs uppercase tracking-[0.22em] text-slate-500">
                                <tr>
                                    <th class="px-6 py-4 font-medium">Usuario</th>
                                    <th class="px-6 py-4 font-medium">Contacto</th>
                                    <th class="px-6 py-4 font-medium">Ubicacion</th>
                                    <th class="px-6 py-4 font-medium">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200/70 text-sm text-slate-700">
                                @forelse ($section['users'] as $user)
                                    <tr class="bg-white/50">
                                        <td class="px-6 py-5">
                                            <div class="flex flex-col gap-1">
                                                <span class="font-semibold text-slate-900">{{ $user->name }}</span>
                                                <span class="text-xs uppercase tracking-[0.2em] text-slate-400">{{ ucfirst($user->role) }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5">
                                            <div class="flex flex-col gap-1">
                                                <span>{{ $user->email }}</span>
                                                <span class="text-slate-500">{{ $user->phone ?: 'Sin telefono' }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 text-slate-500">
                                            {{ collect([$user->city, $user->state, $user->postal_code])->filter()->implode(', ') ?: 'Sin direccion registrada' }}
                                        </td>
                                        <td class="px-6 py-5">
                                            <div class="flex flex-wrap gap-2">
                                                <a href="{{ route('manager.users.edit', $user) }}" class="raph-button-secondary !px-4 !py-2 !text-xs">Editar</a>
                                                <form method="POST" action="{{ route('manager.users.destroy', $user) }}" onsubmit="return confirm('¿Deseas eliminar a este usuario?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="rounded-full border border-rose-200 bg-white px-4 py-2 text-xs font-semibold text-rose-600 transition hover:border-rose-300 hover:bg-rose-50">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-10 text-center text-sm text-slate-500">No hay registros en esta categoria.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($section['users']->hasPages())
                        <div class="border-t border-white/70 px-6 py-4">
                            {{ $section['users']->links() }}
                        </div>
                    @endif
                </section>
            @endforeach
        </div>
    </div>
</x-app-layout>
