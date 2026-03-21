@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-bold text-xs uppercase tracking-widest text-army-green opacity-80 mb-2']) }}>
    {{ $value ?? $slot }}
</label>
