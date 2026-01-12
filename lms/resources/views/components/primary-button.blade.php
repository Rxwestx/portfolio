<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-amber-300 border border-transparent rounded-full font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-400 focus:bg-yellow-500 active:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
