@props([
    'name',
    'value' => null,
    'placeholder' => 'Cari data...',
])

<div class="relative flex items-center w-full">
    <x-ui.icon name="search" class="pointer-events-none absolute left-3 w-4 h-4 stroke-neutral-400 fill-none" />
    
    <input 
        type="text" 
        id="{{ $name }}" 
        name="{{ $name }}" 
        value="{{ old($name, $value) }}" 
        placeholder="{{ $placeholder }}"
        {{ $attributes->merge(['class' => 'w-full pl-9 pr-9 py-2 bg-white border border-neutral-200 text-neutral-900 rounded-lg text-sm font-sans focus:border-primary-600 focus:ring-4 focus:ring-primary-600/10 transition-all outline-none']) }}
    />

    <button 
        type="button" 
        id="{{ $name }}-clear" 
        class="absolute right-3 text-neutral-400 hover:text-neutral-600 focus:outline-none transition-colors cursor-pointer hidden"
    >
        <x-ui.icon name="x" class="w-4 h-4" />
    </button>
</div>
