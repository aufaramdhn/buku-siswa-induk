@props([
    'variant' => 'primary',
    'type' => 'button',
    'href' => null,
])

@php
$baseClasses = 'font-medium px-5 py-2.5 rounded-lg text-sm inline-flex items-center justify-center gap-2 transition-colors cursor-pointer outline-none whitespace-nowrap';

$variants = [
    'primary' => 'bg-primary-600 text-white hover:bg-primary-700 active:bg-primary-950 shadow-sm border border-transparent',
    'secondary' => 'bg-white border border-neutral-200 text-neutral-700 hover:bg-neutral-50 active:bg-neutral-200',
    'danger' => 'bg-danger text-white hover:bg-red-700 active:bg-red-950 shadow-sm border border-transparent',
    'warning' => 'bg-amber-500 text-white hover:bg-amber-600 active:bg-amber-700 shadow-sm border border-transparent',
];

$classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['primary']);
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
