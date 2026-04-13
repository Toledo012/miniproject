<x-guest-layout>
    <div class="mb-8 text-center">
        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-raph-green">Acceso</p>
        <h2 class="mt-3 text-3xl font-semibold tracking-tight text-slate-950">Iniciar sesion</h2>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="correo" value="Correo" class="text-sm font-medium text-slate-700" />
            <x-text-input id="correo" class="mt-2 block w-full rounded-2xl border-white/80 bg-white/80 px-4 py-3 text-slate-900 shadow-sm focus:border-raph-green focus:ring-raph-green/30" type="email" name="correo" :value="old('correo')" required autofocus />
            <x-input-error :messages="$errors->get('correo')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="clave" value="Clave" class="text-sm font-medium text-slate-700" />
            <x-text-input id="clave" class="mt-2 block w-full rounded-2xl border-white/80 bg-white/80 px-4 py-3 text-slate-900 shadow-sm focus:border-raph-green focus:ring-raph-green/30" type="password" name="clave" required />
            <x-input-error :messages="$errors->get('clave')" class="mt-2" />
        </div>

        <label for="remember" class="flex items-center gap-3 text-sm text-slate-600">
            <input id="remember" type="checkbox" class="rounded border-slate-300 text-raph-green focus:ring-raph-green/40" name="remember">
            <span>Recordarme</span>
        </label>

        <button type="submit" class="raph-button-primary w-full !py-3.5">
            Entrar
        </button>
    </form>

    <div class="mt-8 border-t border-slate-200/70 pt-6 text-center text-sm text-slate-600">
        <span>No tienes cuenta?</span>
        <a href="{{ route('register') }}" class="ml-1 font-semibold text-raph-green-dark transition hover:text-raph-green">Registrate</a>
    </div>
</x-guest-layout>
