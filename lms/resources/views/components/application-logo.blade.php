@props([])
<img {{ $attributes->except(['width'])->merge(['class' => 'w-16 h-auto']) }} src="{{ asset('img/characters/rank_1.png') }}"
    alt="Logo">
