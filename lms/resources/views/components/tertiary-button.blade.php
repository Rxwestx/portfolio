<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'relative inline-flex items-center justify-center px-12 py-4 overflow-hidden text-lg font-medium text-blade-dark border-2 border-blade-dark rounded-full hover:text-white group whitespace-nowrap']) }}>
    <span
        class="absolute left-0 block w-full h-0 transition-all bg-blade-dark opacity-100 group-hover:h-full top-1/2 group-hover:top-0 duration-400 ease"></span>
    <span class="relative">{{ $slot }}</span>
</button>
