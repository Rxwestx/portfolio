@props(['disabled' => false])

<input @disabled($disabled)
    {{ $attributes->merge([
        'class' =>
            'rounded-[5px] border border-blade-neon bg-white text-gray-700 shadow-sm focus:border-blade-main focus:outline-none focus:ring-2 focus:ring-blade-main/30' ,
    ]) }}>
