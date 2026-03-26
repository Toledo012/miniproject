<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Crear cuenta de empleado</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('manager.users.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium mb-1" for="name">Nombre</label>
                        <input class="border rounded-md px-3 py-2 w-full" id="name" name="name" type="text" value="{{ old('name') }}" required>
                        @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1" for="email">Correo</label>
                        <input class="border rounded-md px-3 py-2 w-full" id="email" name="email" type="email" value="{{ old('email') }}" required>
                        @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1" for="password">Contrasena</label>
                        <input class="border rounded-md px-3 py-2 w-full" id="password" name="password" type="password" required>
                        @error('password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1" for="password_confirmation">Confirmar contrasena</label>
                        <input class="border rounded-md px-3 py-2 w-full" id="password_confirmation" name="password_confirmation" type="password" required>
                    </div>
                    <div style="display: flex; gap: 10px; align-items: center; margin-top: 12px;">
                        <button type="submit" style="background: #2563eb; color: #ffffff; border: 0; border-radius: 6px; padding: 10px 16px; font-weight: 700; cursor: pointer;">
                            Crear empleado
                        </button>
                        <a href="{{ route('manager.users.index') }}" style="display: inline-block; background: #e5e7eb; color: #111827; padding: 10px 16px; border-radius: 6px; text-decoration: none; font-weight: 600;">
                            Volver
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
