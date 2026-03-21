<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-6 py-3 bg-army-green border border-transparent rounded-lg font-bold text-sm text-white uppercase tracking-widest hover:bg-opacity-90 active:bg-army-green focus:outline-none focus:ring-2 focus:ring-gold focus:ring-offset-2 dark:focus:ring-offset-black transition ease-in-out duration-150 shadow-lg hover:shadow-army-green/20 w-full md:w-auto']) }}>
    {{ $slot }}
</button>
