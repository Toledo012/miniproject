@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center rounded-full bg-slate-950 px-4 py-2 text-sm font-medium leading-5 text-white shadow-sm transition duration-150 ease-in-out'
            : 'inline-flex items-center rounded-full px-4 py-2 text-sm font-medium leading-5 text-slate-600 transition duration-150 ease-in-out hover:bg-white/80 hover:text-slate-900';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
