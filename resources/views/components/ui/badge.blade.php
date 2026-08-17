@props([
    'type' => 'neutral',
])

@php
$baseClasses = 'text-xs px-2.5 py-1 rounded-full font-medium inline-flex items-center gap-1.5';

$types = [
    'success' => 'bg-success-bg text-success-text',
    'warning' => 'bg-warning-bg text-warning-text',
    'danger' => 'bg-danger-bg text-danger-text',
    'neutral' => 'bg-neutral-100 text-neutral-700',
];

$classes = $baseClasses . ' ' . ($types[$type] ?? $types['neutral']);
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</span>
