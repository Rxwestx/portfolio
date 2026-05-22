@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-blade-dark text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-blade-dark transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-700 hover:text-gray-900 hover:border-blade-main focus:outline-none focus:text-gray-900 focus:border-blade-main transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
