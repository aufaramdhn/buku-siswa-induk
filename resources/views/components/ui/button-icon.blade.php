@props([
    'icon',
    'variant' => 'secondary',
    'type' => 'button',
    'href' => null,
])

@php
$baseClasses = 'w-9 h-9 rounded-lg flex items-center justify-center bg-white border border-neutral-200 transition-colors cursor-pointer outline-none select-none hover:bg-neutral-50 active:bg-neutral-100';

$iconColors = [
    'primary' => 'text-blue-600 stroke-blue-600',
    'warning' => 'text-amber-600 stroke-amber-600',
    'danger' => 'text-red-600 stroke-red-600',
    'secondary' => 'text-neutral-700 stroke-neutral-700',
];

$iconColorClass = $iconColors[$variant] ?? $iconColors['secondary'];
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $baseClasses]) }}>
        <x-ui.icon :name="$icon" class="w-4 h-4 {{ $iconColorClass }}" />
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $baseClasses]) }}>
        <x-ui.icon :name="$icon" class="w-4 h-4 {{ $iconColorClass }}" />
    </button>
@endif
