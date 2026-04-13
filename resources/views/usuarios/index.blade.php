<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-raph-green">Usuarios</p>
                <h1 class="mt-2 text-3xl font-semibold tracking-tight text-slate-950">Gestion de cuentas</h1>
            </div>
            @can('create', \App\Models\Usuario::class)
                <a href="{{ route('usuarios.create') }}" class="raph-button-primary">Nuevo usuario</a>
            @endcan
        </div>
    </x-slot>

    <div class="page-section">
        <div class="mx-auto max-w-7xl space-y-6">
            @if (session('status'))
                <div class="glass-card p-4 text-sm text-slate-600">{{ session('status') }}</div>
            @endif

            @foreach (['Administradores' => $administradores, 'Gerentes' => $gerentes, 'Clientes' => $clientes] as $titulo => $coleccion)
                <section class="glass-card p-6 sm:p-8">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-raph-green">{{ $titulo }}</p>
                        <h2 class="mt-2 text-2xl font-semibold text-slate-950">{{ $coleccion->total() }} registros</h2>
                    </div>

                    <div class="mt-6 overflow-hidden rounded-[28px] border border-white/80 bg-white/80">
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-left">
                                <thead class="border-b border-slate-200/70 text-xs uppercase tracking-[0.24em] text-slate-500">
                                    <tr>
                                        <th class="px-6 py-4">Nombre</th>
                                        <th class="px-6 py-4">Correo</th>
                                        <th class="px-6 py-4">Rol</th>
                                        <th class="px-6 py-4 text-right">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200/70 text-sm text-slate-700">
                                    @forelse ($coleccion as $usuario)
                                        <tr>
                                            <td class="px-6 py-4 font-medium text-slate-900">{{ $usuario->nombre }} {{ $usuario->apellidos }}</td>
                                            <td class="px-6 py-4">{{ $usuario->correo }}</td>
                                            <td class="px-6 py-4 capitalize">{{ $usuario->rol }}</td>
                                            <td class="px-6 py-4">
                                                <div class="flex justify-end gap-3">
                                                    @can('update', $usuario)
                                                        <a href="{{ route('usuarios.edit', $usuario) }}" class="text-sm font-medium text-raph-green-dark transition hover:text-raph-green">Editar</a>
                                                    @endcan
                                                    @can('delete', $usuario)
                                                        <form method="POST" action="{{ route('usuarios.destroy', $usuario) }}" onsubmit="return confirm('Se eliminara este usuario.');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-sm font-medium text-rose-600 transition hover:text-rose-700">Eliminar</button>
                                                        </form>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-8 text-center text-slate-500">No hay registros en esta seccion.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mt-5">
                        {{ $coleccion->links() }}
                    </div>
                </section>
            @endforeach
        </div>
    </div>
</x-app-layout>
