@props([
    'id',
    'action' => '',
    'method' => 'POST',
    'title',
    'confirmText' => 'Konfirmasi',
    'confirmVariant' => 'primary',
    'icon' => null,
    'iconVariant' => null,
])

@php
$resolvedVariant = $iconVariant ?? ($confirmVariant === 'danger' ? 'danger' : 'primary');
$resolvedIcon = $icon ?? ($resolvedVariant === 'danger' ? 'trash' : 'info');

$iconColor = $resolvedVariant === 'danger' 
    ? 'text-danger stroke-danger' 
    : ($resolvedVariant === 'warning' 
        ? 'text-warning stroke-warning' 
        : 'text-blue-600 stroke-blue-600');

$iconBg = $resolvedVariant === 'danger' 
    ? 'bg-danger-bg border border-danger-bg/10' 
    : ($resolvedVariant === 'warning' 
        ? 'bg-warning-bg border border-warning-bg/10' 
        : 'bg-blue-50 border border-blue-100');
@endphp

<x-feedback.modal :id="$id" size="max-w-md">
    <form action="{{ $action }}" method="POST" id="{{ $id }}-form">
        @csrf
        @if(in_array(strtoupper($method), ['PUT', 'PATCH', 'DELETE']))
            @method($method)
        @endif

        <div class="flex flex-col items-center text-center">
            <div class="w-12 h-12 rounded-full {{ $iconBg }} flex items-center justify-center mb-4 flex-shrink-0">
                <x-ui.icon :name="$resolvedIcon" class="w-6 h-6 {{ $iconColor }}" />
            </div>
            
            <h3 class="text-lg font-semibold text-neutral-900 mb-2 font-sans">{{ $title }}</h3>
            <p class="text-sm text-neutral-500 mb-6 font-sans">
                {{ $slot }}
            </p>
            
            <div class="grid grid-cols-2 gap-3 w-full">
                <x-ui.button 
                    variant="secondary" 
                    type="button"
                    class="w-full modal-close-btn"
                    data-modal-dismiss="#{{ $id }}"
                >
                    Batal
                </x-ui.button>
                
                <x-ui.button 
                    :variant="$confirmVariant" 
                    type="submit"
                    class="w-full"
                >
                    {{ $confirmText }}
                </x-ui.button>
            </div>
        </div>
    </form>
</x-feedback.modal>
