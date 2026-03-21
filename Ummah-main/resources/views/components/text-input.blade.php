@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 bg-white text-gray-700 focus:border-army-green focus:ring-army-green rounded-lg shadow-sm transition-all duration-200']) }}>
