<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2">
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-raph-green">RAPH</p>
            <h1 class="text-3xl font-semibold tracking-tight text-slate-950">Crear usuario</h1>
            <p class="max-w-2xl text-sm text-slate-600">Crea nuevas cuentas y define su acceso desde un mismo lugar.</p>
        </div>
    </x-slot>

    <div class="page-section">
        <div class="mx-auto max-w-5xl">
            <div class="glass-card p-8 sm:p-10">
                <form method="POST" action="{{ route('manager.users.store') }}" class="space-y-8">
                    @csrf

                    @include('manager.users._form')

                    <div class="flex flex-wrap items-center gap-3 border-t border-slate-200/70 pt-6">
                        <button type="submit" class="raph-button-primary">Guardar usuario</button>
                        <a href="{{ route('manager.users.index') }}" class="raph-button-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
