@props(['active'])

@php
    $classes =
        $active ?? false
            ? 'block w-full border-l-4 border-blade-main bg-blade-soft py-2.5 pe-4 ps-3 text-start text-base font-semibold text-gray-900 transition duration-150 ease-in-out focus:outline-none focus:border-blade-main'
            : 'block w-full border-l-4 border-transparent py-2.5 pe-4 ps-3 text-start text-base font-medium text-gray-600 transition duration-150 ease-in-out hover:border-blade-neon hover:bg-blade-pale hover:text-gray-900 focus:outline-none focus:border-blade-neon focus:bg-blade-pale focus:text-gray-900';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
