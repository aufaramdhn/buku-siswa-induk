@props([
    'type' => 'success',
    'message',
])

@php
$bgClass = $type === 'success' ? 'bg-success-bg border-success text-success-text' : 'bg-danger-bg border-danger text-danger-text';
$iconName = $type === 'success' ? 'activity' : 'trash';
@endphp

<div 
    class="toast-notification fixed top-5 right-5 z-50 flex items-center gap-3 px-4 py-3 rounded-xl border shadow-lg transition-all duration-300 transform translate-x-12 opacity-0 {{ $bgClass }}"
    role="alert"
>
    <x-ui.icon :name="$iconName" class="w-5 h-5 stroke-current" />
    <span class="text-sm font-medium font-sans">{{ $message }}</span>
</div>
