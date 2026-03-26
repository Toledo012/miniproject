@php
    $editing = isset($user);
@endphp

<div class="grid gap-5 md:grid-cols-2">
    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-slate-700" for="name">Nombre completo</label>
        <input class="mt-2 w-full rounded-2xl border border-white/70 bg-white/80 px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition focus:border-raph-green focus:ring-4 focus:ring-raph-green/15" id="name" name="name" type="text" value="{{ old('name', $user->name ?? '') }}" required>
        @error('name') <p class="mt-2 text-sm text-rose-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-slate-700" for="email">Correo electronico</label>
        <input class="mt-2 w-full rounded-2xl border border-white/70 bg-white/80 px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition focus:border-raph-green focus:ring-4 focus:ring-raph-green/15" id="email" name="email" type="email" value="{{ old('email', $user->email ?? '') }}" required>
        @error('email') <p class="mt-2 text-sm text-rose-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-slate-700" for="role">Rol</label>
        <select class="mt-2 w-full rounded-2xl border border-white/70 bg-white/80 px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition focus:border-raph-green focus:ring-4 focus:ring-raph-green/15" id="role" name="role" required>
            @foreach ($roles as $value => $label)
                <option value="{{ $value }}" @selected(old('role', $user->role ?? \App\Models\User::ROLE_CLIENTE) === $value)>{{ $label }}</option>
            @endforeach
        </select>
        @error('role') <p class="mt-2 text-sm text-rose-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-slate-700" for="phone">Telefono</label>
        <input class="mt-2 w-full rounded-2xl border border-white/70 bg-white/80 px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition focus:border-raph-green focus:ring-4 focus:ring-raph-green/15" id="phone" name="phone" type="text" value="{{ old('phone', $user->phone ?? '') }}">
        @error('phone') <p class="mt-2 text-sm text-rose-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-slate-700" for="postal_code">Codigo postal</label>
        <input class="mt-2 w-full rounded-2xl border border-white/70 bg-white/80 px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition focus:border-raph-green focus:ring-4 focus:ring-raph-green/15" id="postal_code" name="postal_code" type="text" value="{{ old('postal_code', $user->postal_code ?? '') }}">
        @error('postal_code') <p class="mt-2 text-sm text-rose-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-slate-700" for="city">Ciudad</label>
        <input class="mt-2 w-full rounded-2xl border border-white/70 bg-white/80 px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition focus:border-raph-green focus:ring-4 focus:ring-raph-green/15" id="city" name="city" type="text" value="{{ old('city', $user->city ?? '') }}">
        @error('city') <p class="mt-2 text-sm text-rose-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-slate-700" for="state">Estado</label>
        <input class="mt-2 w-full rounded-2xl border border-white/70 bg-white/80 px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition focus:border-raph-green focus:ring-4 focus:ring-raph-green/15" id="state" name="state" type="text" value="{{ old('state', $user->state ?? '') }}">
        @error('state') <p class="mt-2 text-sm text-rose-600">{{ $message }}</p> @enderror
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-slate-700" for="address">Direccion</label>
        <input class="mt-2 w-full rounded-2xl border border-white/70 bg-white/80 px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition focus:border-raph-green focus:ring-4 focus:ring-raph-green/15" id="address" name="address" type="text" value="{{ old('address', $user->address ?? '') }}">
        @error('address') <p class="mt-2 text-sm text-rose-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-slate-700" for="password">{{ $editing ? 'Nueva contrasena' : 'Contrasena' }}</label>
        <input class="mt-2 w-full rounded-2xl border border-white/70 bg-white/80 px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition focus:border-raph-green focus:ring-4 focus:ring-raph-green/15" id="password" name="password" type="password" {{ $editing ? '' : 'required' }}>
        <p class="mt-2 text-xs text-slate-500">{{ $editing ? 'Deja este campo vacio si no deseas cambiarla.' : 'Usa una contrasena segura para el usuario.' }}</p>
        @error('password') <p class="mt-2 text-sm text-rose-600">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-slate-700" for="password_confirmation">Confirmar contrasena</label>
        <input class="mt-2 w-full rounded-2xl border border-white/70 bg-white/80 px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition focus:border-raph-green focus:ring-4 focus:ring-raph-green/15" id="password_confirmation" name="password_confirmation" type="password" {{ $editing ? '' : 'required' }}>
    </div>
</div>
