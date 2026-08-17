@props([
    'label',
    'name',
    'helper' => null,
    'required' => false,
])

<div {{ $attributes->merge(['class' => 'w-full']) }}>
    <label for="{{ $name }}" class="text-sm font-medium text-neutral-700 mb-1.5 block select-none">
        {{ $label }}
        @if($required)
            <span class="text-danger font-bold ml-0.5" title="Wajib Diisi">*</span>
        @endif
    </label>
    
    <div class="relative">
        {{ $slot }}
    </div>

    @if($helper)
        <p class="text-xs text-neutral-400 mt-1 block select-none">{{ $helper }}</p>
    @endif

    @error($name)
        <span class="text-danger text-xs mt-1 block font-sans font-medium">{{ $message }}</span>
    @enderror
</div>
