@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full rounded-2xl bg-slate-950 px-4 py-3 text-start text-base font-medium text-white transition duration-150 ease-in-out'
            : 'block w-full rounded-2xl px-4 py-3 text-start text-base font-medium text-slate-600 transition duration-150 ease-in-out hover:bg-white/80 hover:text-slate-900';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
