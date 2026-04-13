<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-raph-green">Usuarios</p>
            <h1 class="mt-2 text-3xl font-semibold tracking-tight text-slate-950">Editar cuenta</h1>
        </div>
    </x-slot>

    <div class="page-section">
        <div class="mx-auto max-w-4xl">
            <div class="glass-card p-6 sm:p-8">
                <form method="POST" action="{{ route('usuarios.update', $usuario) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid gap-6 sm:grid-cols-2">
                        <div>
                            <x-input-label for="nombre" value="Nombre" />
                            <x-text-input id="nombre" name="nombre" type="text" class="mt-2 block w-full rounded-2xl border-white/80 bg-white/80" :value="old('nombre', $usuario->nombre)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('nombre')" />
                        </div>
                        <div>
                            <x-input-label for="apellidos" value="Apellidos" />
                            <x-text-input id="apellidos" name="apellidos" type="text" class="mt-2 block w-full rounded-2xl border-white/80 bg-white/80" :value="old('apellidos', $usuario->apellidos)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('apellidos')" />
                        </div>
                    </div>

                    <div class="grid gap-6 sm:grid-cols-2">
                        <div>
                            <x-input-label for="correo" value="Correo" />
                            <x-text-input id="correo" name="correo" type="email" class="mt-2 block w-full rounded-2xl border-white/80 bg-white/80" :value="old('correo', $usuario->correo)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('correo')" />
                        </div>
                        <div>
                            <x-input-label for="rol" value="Rol" />
                            <select id="rol" name="rol" class="mt-2 block w-full rounded-2xl border-white/80 bg-white/80">
                                @foreach ($roles as $valor => $etiqueta)
                                    <option value="{{ $valor }}" @selected(old('rol', $usuario->rol) === $valor)>{{ $etiqueta }}</option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('rol')" />
                        </div>
                    </div>

                    <div class="grid gap-6 sm:grid-cols-2">
                        <div>
                            <x-input-label for="clave" value="Nueva clave" />
                            <x-text-input id="clave" name="clave" type="password" class="mt-2 block w-full rounded-2xl border-white/80 bg-white/80" />
                            <p class="mt-2 text-sm text-slate-500">Dejalo vacio si no deseas cambiarla.</p>
                            <x-input-error class="mt-2" :messages="$errors->get('clave')" />
                        </div>
                        <div>
                            <x-input-label for="clave_confirmation" value="Confirmar clave" />
                            <x-text-input id="clave_confirmation" name="clave_confirmation" type="password" class="mt-2 block w-full rounded-2xl border-white/80 bg-white/80" />
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-3 border-t border-slate-200/70 pt-6">
                        <button type="submit" class="raph-button-primary">Guardar cambios</button>
                        <a href="{{ route('usuarios.index') }}" class="raph-button-secondary">Volver</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
