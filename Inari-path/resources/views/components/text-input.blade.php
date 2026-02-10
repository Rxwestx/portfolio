@props(['disabled' => false])

<input @disabled($disabled)
    {{ $attributes->merge([
        'class' =>
            'border-gray-300 focus:border-blade-dark focus:ring-2 focus:ring-offset-1 focus:ring-blade-dark focus:outline-none rounded-md shadow-sm bg-blade-neon text-gray-600' ,
    ]) }}>
