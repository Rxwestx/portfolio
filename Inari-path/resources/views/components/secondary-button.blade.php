<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex min-h-10 items-center justify-center rounded-[5px] border border-blade-neon bg-white px-4 py-2 text-sm font-semibold text-blade-main transition ease-in-out duration-150 hover:bg-blade-soft focus:outline-none focus:ring-2 focus:ring-blade-main focus:ring-offset-2 disabled:opacity-25']) }}>
    {{ $slot }}
</button>
