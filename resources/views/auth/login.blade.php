<x-guest-layout>
    <x-auth-session-status class="mb-5 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700" :status="session('status')" />

    <div class="mb-8 text-center">
        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-raph-green">Acceso seguro</p>
        <h2 class="mt-3 text-3xl font-semibold tracking-tight text-slate-950">Iniciar sesion</h2>
        <p class="mt-3 text-sm leading-6 text-slate-500">Entra y continua justo donde lo dejaste.</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" value="Correo" class="text-sm font-medium text-slate-700" />
            <x-text-input id="email" class="mt-2 block w-full rounded-2xl border-white/80 bg-white/80 px-4 py-3 text-slate-900 shadow-sm focus:border-raph-green focus:ring-raph-green/30" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <div class="flex items-center justify-between gap-3">
                <x-input-label for="password" value="Contrasena" class="text-sm font-medium text-slate-700" />
                @if (Route::has('password.request'))
                    <a class="text-sm font-medium text-slate-500 transition hover:text-slate-900" href="{{ route('password.request') }}">
                        ¿Olvidaste tu contrasena?
                    </a>
                @endif
            </div>

            <x-text-input id="password" class="mt-2 block w-full rounded-2xl border-white/80 bg-white/80 px-4 py-3 text-slate-900 shadow-sm focus:border-raph-green focus:ring-raph-green/30"
                type="password"
                name="password"
                required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <label for="remember_me" class="flex items-center gap-3 text-sm text-slate-600">
            <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-raph-green focus:ring-raph-green/40" name="remember">
            <span>Recordarme en este equipo</span>
        </label>

        <button type="submit" class="raph-button-primary w-full !py-3.5">
            Iniciar sesion
        </button>
    </form>

    <div class="mt-8 border-t border-slate-200/70 pt-6 text-center text-sm text-slate-600">
        <span>No tienes cuenta todavia?</span>
        <a href="{{ route('register') }}" class="ml-1 font-semibold text-raph-green-dark transition hover:text-raph-green">Crear cuenta</a>
    </div>
</x-guest-layout>
