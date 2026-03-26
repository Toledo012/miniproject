<x-guest-layout>
    <div class="mb-8 text-center">
        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-raph-green">Nueva cuenta</p>
        <h2 class="mt-3 text-3xl font-semibold tracking-tight text-slate-950">Crear cuenta</h2>
        <p class="mt-3 text-sm leading-6 text-slate-500">Empieza en RAPH en menos de un minuto.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="name" value="Nombre" class="text-sm font-medium text-slate-700" />
            <x-text-input id="name" class="mt-2 block w-full rounded-2xl border-white/80 bg-white/80 px-4 py-3 text-slate-900 shadow-sm focus:border-raph-green focus:ring-raph-green/30" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" value="Correo" class="text-sm font-medium text-slate-700" />
            <x-text-input id="email" class="mt-2 block w-full rounded-2xl border-white/80 bg-white/80 px-4 py-3 text-slate-900 shadow-sm focus:border-raph-green focus:ring-raph-green/30" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" value="Contrasena" class="text-sm font-medium text-slate-700" />
            <x-text-input id="password" class="mt-2 block w-full rounded-2xl border-white/80 bg-white/80 px-4 py-3 text-slate-900 shadow-sm focus:border-raph-green focus:ring-raph-green/30"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" value="Confirmar contrasena" class="text-sm font-medium text-slate-700" />
            <x-text-input id="password_confirmation" class="mt-2 block w-full rounded-2xl border-white/80 bg-white/80 px-4 py-3 text-slate-900 shadow-sm focus:border-raph-green focus:ring-raph-green/30"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <button type="submit" class="raph-button-primary w-full !py-3.5">
            Crear cuenta
        </button>
    </form>

    <div class="mt-8 border-t border-slate-200/70 pt-6 text-center text-sm text-slate-600">
        <span>Ya tienes cuenta?</span>
        <a class="ml-1 font-semibold text-raph-green-dark transition hover:text-raph-green" href="{{ route('login') }}">
            Iniciar sesion
        </a>
    </div>
</x-guest-layout>
