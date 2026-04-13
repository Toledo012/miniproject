<x-guest-layout>
    <div class="mb-8 text-center">
        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-raph-green">Registro</p>
        <h2 class="mt-3 text-3xl font-semibold tracking-tight text-slate-950">Crear cuenta</h2>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div class="grid gap-5 md:grid-cols-2">
            <div>
                <x-input-label for="nombre" value="Nombre" class="text-sm font-medium text-slate-700" />
                <x-text-input id="nombre" class="mt-2 block w-full rounded-2xl border-white/80 bg-white/80 px-4 py-3 text-slate-900 shadow-sm focus:border-raph-green focus:ring-raph-green/30" type="text" name="nombre" :value="old('nombre')" required autofocus />
                <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="apellidos" value="Apellidos" class="text-sm font-medium text-slate-700" />
                <x-text-input id="apellidos" class="mt-2 block w-full rounded-2xl border-white/80 bg-white/80 px-4 py-3 text-slate-900 shadow-sm focus:border-raph-green focus:ring-raph-green/30" type="text" name="apellidos" :value="old('apellidos')" required />
                <x-input-error :messages="$errors->get('apellidos')" class="mt-2" />
            </div>
        </div>

        <div>
            <x-input-label for="correo" value="Correo" class="text-sm font-medium text-slate-700" />
            <x-text-input id="correo" class="mt-2 block w-full rounded-2xl border-white/80 bg-white/80 px-4 py-3 text-slate-900 shadow-sm focus:border-raph-green focus:ring-raph-green/30" type="email" name="correo" :value="old('correo')" required />
            <x-input-error :messages="$errors->get('correo')" class="mt-2" />
        </div>

        <div class="grid gap-5 md:grid-cols-2">
            <div>
                <x-input-label for="clave" value="Clave" class="text-sm font-medium text-slate-700" />
                <x-text-input id="clave" class="mt-2 block w-full rounded-2xl border-white/80 bg-white/80 px-4 py-3 text-slate-900 shadow-sm focus:border-raph-green focus:ring-raph-green/30" type="password" name="clave" required />
                <x-input-error :messages="$errors->get('clave')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="clave_confirmation" value="Confirmar clave" class="text-sm font-medium text-slate-700" />
                <x-text-input id="clave_confirmation" class="mt-2 block w-full rounded-2xl border-white/80 bg-white/80 px-4 py-3 text-slate-900 shadow-sm focus:border-raph-green focus:ring-raph-green/30" type="password" name="clave_confirmation" required />
            </div>
        </div>

        <button type="submit" class="raph-button-primary w-full !py-3.5">
            Crear cuenta
        </button>
    </form>

    <div class="mt-8 border-t border-slate-200/70 pt-6 text-center text-sm text-slate-600">
        <span>Ya tienes cuenta?</span>
        <a href="{{ route('login') }}" class="ml-1 font-semibold text-raph-green-dark transition hover:text-raph-green">Inicia sesion</a>
    </div>
</x-guest-layout>
