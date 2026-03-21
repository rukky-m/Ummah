@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-4 py-2 bg-gradient-to-br from-gold/10 to-transparent border border-gold/30 rounded-xl text-[11px] font-black uppercase tracking-widest text-gold shadow-[0_0_15px_rgba(234,179,8,0.15)] focus:outline-none transition-all duration-300 ease-in-out'
            : 'inline-flex items-center px-4 py-2 border border-transparent rounded-xl text-[11px] font-bold uppercase tracking-widest text-emerald-100/60 hover:text-white hover:bg-white/5 hover:border-white/10 focus:outline-none focus:text-white focus:bg-white/5 transition-all duration-300 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
