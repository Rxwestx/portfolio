@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center border-b-2 border-blade-main px-1 pt-1 text-sm font-semibold leading-5 text-gray-900 transition duration-150 ease-in-out focus:outline-none focus:border-blade-main'
            : 'inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium leading-5 text-gray-600 transition duration-150 ease-in-out hover:border-blade-neon hover:text-gray-900 focus:outline-none focus:border-blade-neon focus:text-gray-900';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
