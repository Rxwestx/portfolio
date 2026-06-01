<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex min-h-10 items-center justify-center rounded-[5px] border border-transparent bg-blade-main px-4 py-2 text-sm font-semibold text-white transition ease-in-out duration-150 hover:bg-blade-main/90 focus:outline-none focus:ring-2 focus:ring-blade-main focus:ring-offset-2 active:bg-blade-main/90']) }}>
    {{ $slot }}
</button>
