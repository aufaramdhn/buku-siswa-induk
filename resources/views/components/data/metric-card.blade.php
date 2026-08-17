@props([
    'title',
    'value',
    'icon',
    'variant' => 'primary',
])

@php
$variants = [
    'primary' => ['bg' => 'bg-primary-50', 'text' => 'text-primary-600 stroke-primary-600'],
    'success' => ['bg' => 'bg-success-bg', 'text' => 'text-success-text stroke-success-text'],
    'danger' => ['bg' => 'bg-danger-bg', 'text' => 'text-danger-text stroke-danger-text'],
    'warning' => ['bg' => 'bg-warning-bg', 'text' => 'text-warning-text stroke-warning-text'],
    'neutral' => ['bg' => 'bg-neutral-50', 'text' => 'text-neutral-700 stroke-neutral-700'],
];

$active = $variants[$variant] ?? $variants['primary'];
@endphp

<x-ui.card class="flex items-center justify-between">
    <div class="flex flex-col gap-1 select-none">
        <span class="text-xs font-semibold text-neutral-400 uppercase tracking-wider font-sans">
            {{ $title }}
        </span>
        <span class="text-2xl font-bold text-neutral-900 tracking-tight font-sans">
            {{ $value }}
        </span>
    </div>
    
    <div class="w-12 h-12 rounded-xl {{ $active['bg'] }} flex items-center justify-center border border-neutral-100/10">
        <x-ui.icon :name="$icon" class="w-6 h-6 {{ $active['text'] }}" />
    </div>
</x-ui.card>
