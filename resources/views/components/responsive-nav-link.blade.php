@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-3 border-l-4 border-gold text-start text-xs font-bold uppercase tracking-widest text-[#0f172a] bg-gold focus:outline-none transition-all duration-300 ease-in-out'
            : 'block w-full ps-3 pe-4 py-3 border-l-4 border-transparent text-start text-xs font-bold uppercase tracking-widest text-gray-400 hover:text-white hover:bg-white/5 hover:border-white/20 focus:outline-none focus:text-white focus:bg-white/5 focus:border-white/20 transition-all duration-300 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
