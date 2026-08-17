@props([
    'route',
    'active' => false,
    'icon',
])

@php
$baseClasses = 'flex items-center gap-3 px-3 py-2.5 text-sm rounded-lg transition-all cursor-pointer';
$activeClasses = 'font-semibold text-neutral-900 bg-white shadow-sm';
$inactiveClasses = 'font-medium text-zinc-400 hover:bg-white/5 hover:text-white';

$classes = $active ? $baseClasses . ' ' . $activeClasses : $baseClasses . ' ' . $inactiveClasses;
$iconClass = $active ? 'stroke-neutral-900 w-5 h-5' : 'stroke-zinc-400 w-5 h-5';
@endphp

<a href="{{ $route }}" {{ $attributes->merge(['class' => $classes]) }}>
    <x-ui.icon :name="$icon" :class="$iconClass" />
    <span class="sidebar-text">{{ $slot }}</span>
</a>
