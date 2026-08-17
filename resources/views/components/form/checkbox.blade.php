@props([
    'name',
    'value' => '1',
    'checked' => false,
    'label' => null,
])

<label class="flex items-center gap-3 cursor-pointer select-none">
    <div class="relative flex items-center justify-center">
        <input 
            type="checkbox" 
            name="{{ $name }}" 
            value="{{ $value }}" 
            {{ $checked ? 'checked' : '' }} 
            {{ $attributes->merge(['class' => 'sr-only']) }}
        />
        <div class="w-5 h-5 rounded border border-neutral-200 bg-white flex items-center justify-center transition-all">
            <svg class="w-3 h-3 text-white fill-none stroke-current stroke-2 opacity-0 transition-opacity" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
        </div>
    </div>
    @if($label)
        <span class="text-sm font-medium text-neutral-700">{{ $label }}</span>
    @endif
</label>
