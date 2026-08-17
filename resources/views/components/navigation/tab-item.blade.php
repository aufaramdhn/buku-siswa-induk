@props([
    'target',
    'active' => false,
    'label',
])

@php
$baseClasses = 'px-4 py-2.5 text-sm cursor-pointer select-none transition-all border-b-2 font-sans';
$activeClasses = 'text-blue-600 border-blue-600 font-semibold';
$inactiveClasses = 'text-neutral-500 border-transparent hover:text-neutral-700 font-medium';

$classes = $active ? $baseClasses . ' ' . $activeClasses : $baseClasses . ' ' . $inactiveClasses;
@endphp

<button 
    type="button" 
    data-tab-target="#{{ $target }}"
    {{ $attributes->merge(['class' => $classes]) }}
>
    {{ $label }}
</button>
