<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-blade-main border border-transparent rounded-full font-semibold text-xs text-white uppercase tracking-widest hover:bg-blade-dark focus:bg-blade-dark active:bg-blade-dark focus:outline-none focus:ring-2 focus:ring-blade-dark focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
