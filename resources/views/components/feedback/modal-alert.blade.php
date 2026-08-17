@props([
    'id',
    'type' => 'success',
    'title' => 'Pemberitahuan',
    'message',
])

@php
$icons = [
    'success' => ['name' => 'check', 'color' => 'text-blue-600 stroke-blue-600', 'bg' => 'bg-blue-50 border-blue-100'],
    'warning' => ['name' => 'info', 'color' => 'text-amber-600 stroke-amber-600', 'bg' => 'bg-amber-50 border-amber-100'],
    'danger' => ['name' => 'x', 'color' => 'text-red-600 stroke-red-600', 'bg' => 'bg-red-50 border-red-100'],
];
$activeIcon = $icons[$type] ?? $icons['success'];
@endphp

<x-feedback.modal :id="$id" size="max-w-md">
    <div class="flex flex-col items-center text-center">
        <div class="w-12 h-12 rounded-full {{ $activeIcon['bg'] }} flex items-center justify-center mb-4 border">
            <x-ui.icon :name="$activeIcon['name']" class="w-6 h-6 {{ $activeIcon['color'] }}" />
        </div>
        
        <h3 class="text-lg font-bold text-neutral-900 mb-1 font-sans">{{ $title }}</h3>
        <p class="text-sm text-neutral-500 mb-6 font-sans leading-relaxed">{{ $message }}</p>
        
        <x-ui.button 
            variant="primary" 
            class="w-full modal-close-btn"
            data-modal-dismiss="#{{ $id }}"
        >
            Mengerti
        </x-ui.button>
    </div>
</x-feedback.modal>
