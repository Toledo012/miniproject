<x-app-layout>
    <x-slot name="header">
        <div style="display: flex; align-items: center; justify-content: space-between; gap: 10px; flex-wrap: wrap;">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Usuarios</h2>
            <a href="{{ route('manager.users.create') }}" style="display: inline-block; background: #2563eb; color: #ffffff; padding: 10px 14px; border-radius: 6px; text-decoration: none; font-weight: 700;">
                + Crear empleado nuevo
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6" style="display: grid; gap: 18px;">
                @if (session('status'))
                    <p class="mb-4 text-green-700">{{ session('status') }}</p>
                @endif

                <section>
                    <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 10px;">Empleados</h3>
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse; border: 1px solid #d1d5db;">
                            <thead>
                                <tr>
                                    <th style="text-align: left; padding: 10px; border: 1px solid #d1d5db;">Nombre</th>
                                    <th style="text-align: left; padding: 10px; border: 1px solid #d1d5db;">Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($employees as $user)
                                    <tr>
                                        <td style="padding: 10px; border: 1px solid #d1d5db;">{{ $user->name }}</td>
                                        <td style="padding: 10px; border: 1px solid #d1d5db;">{{ $user->email }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" style="padding: 10px; border: 1px solid #d1d5db; color: #6b7280;">No hay empleados registrados.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">{{ $employees->links() }}</div>
                </section>

                <section>
                    <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 10px;">Clientes</h3>
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse; border: 1px solid #d1d5db;">
                            <thead>
                                <tr>
                                    <th style="text-align: left; padding: 10px; border: 1px solid #d1d5db;">Nombre</th>
                                    <th style="text-align: left; padding: 10px; border: 1px solid #d1d5db;">Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($clients as $user)
                                    <tr>
                                        <td style="padding: 10px; border: 1px solid #d1d5db;">{{ $user->name }}</td>
                                        <td style="padding: 10px; border: 1px solid #d1d5db;">{{ $user->email }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" style="padding: 10px; border: 1px solid #d1d5db; color: #6b7280;">No hay clientes registrados.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">{{ $clients->links() }}</div>
                </section>

                <section>
                    <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 10px;">Gerentes</h3>
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse; border: 1px solid #d1d5db;">
                            <thead>
                                <tr>
                                    <th style="text-align: left; padding: 10px; border: 1px solid #d1d5db;">Nombre</th>
                                    <th style="text-align: left; padding: 10px; border: 1px solid #d1d5db;">Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($managers as $user)
                                    <tr>
                                        <td style="padding: 10px; border: 1px solid #d1d5db;">{{ $user->name }}</td>
                                        <td style="padding: 10px; border: 1px solid #d1d5db;">{{ $user->email }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" style="padding: 10px; border: 1px solid #d1d5db; color: #6b7280;">No hay gerentes registrados.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">{{ $managers->links() }}</div>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
