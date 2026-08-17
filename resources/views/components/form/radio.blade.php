@props([
    'name',
    'value',
    'checked' => false,
    'label' => null,
])

<label class="flex items-center gap-3 cursor-pointer select-none">
    <div class="relative flex items-center justify-center">
        <input 
            type="radio" 
            name="{{ $name }}" 
            value="{{ $value }}" 
            {{ $checked ? 'checked' : '' }} 
            {{ $attributes->merge(['class' => 'sr-only']) }}
        />
        <div class="w-5 h-5 rounded-full border border-neutral-200 bg-white flex items-center justify-center transition-all">
            <div class="w-2.5 h-2.5 rounded-full bg-primary-600 opacity-0 transition-opacity"></div>
        </div>
    </div>
    @if($label)
        <span class="text-sm font-medium text-neutral-700">{{ $label }}</span>
    @endif
</label>
