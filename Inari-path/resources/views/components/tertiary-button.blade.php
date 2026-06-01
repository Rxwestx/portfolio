<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'relative inline-flex min-h-10 items-center justify-center overflow-hidden rounded-[5px] border border-blade-main px-6 py-2 text-sm font-semibold text-blade-main transition ease-in-out duration-150 hover:text-white focus:outline-none focus:ring-2 focus:ring-blade-main focus:ring-offset-2 group whitespace-nowrap']) }}>
    <span
        class="absolute left-0 block w-full h-0 transition-all bg-blade-main opacity-100 group-hover:h-full top-1/2 group-hover:top-0 duration-300 ease"></span>
    <span class="relative">{{ $slot }}</span>
</button>
