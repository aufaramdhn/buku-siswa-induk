@props([
    'name',
    'value' => null,
])

@php
$hasError = $errors->has($name);
$oldValue = old($name, $value);
$baseClasses = 'w-full pl-4 pr-10 py-2.5 bg-white border border-neutral-200 text-neutral-900 rounded-lg text-sm appearance-none focus:border-primary-600 focus:ring-4 focus:ring-primary-600/10 transition-all outline-none';
$classes = $hasError ? $baseClasses . ' has-error' : $baseClasses;
@endphp

<div class="relative w-full custom-select-wrapper" data-name="{{ $name }}">
    <select 
        id="{{ $name }}" 
        name="{{ $name }}" 
        class="hidden-native-select sr-only {{ $hasError ? 'has-error' : '' }}"
        {{ $attributes }}
    >
        {{ $slot }}
    </select>

    <button 
        type="button"
        class="custom-select-trigger w-full flex items-center justify-between pl-4 pr-3 py-2.5 bg-white border text-neutral-900 rounded-lg text-sm transition-all outline-none cursor-pointer select-none {{ $hasError ? 'border-danger focus:border-danger focus:ring-4 focus:ring-danger/10 has-error' : 'border-neutral-200 focus:border-primary-600 focus:ring-4 focus:ring-primary-600/10' }}"
    >
        <span class="custom-select-label truncate">Pilih...</span>
        <svg class="w-4 h-4 text-neutral-500 flex-shrink-0 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <polyline points="6 9 12 15 18 9"></polyline>
        </svg>
    </button>

    <div class="dropdown-menu custom-select-dropdown absolute left-0 right-0 mt-1.5 bg-white border border-neutral-200 rounded-lg shadow-lg py-1.5 z-50 hidden max-h-60 overflow-y-auto transform scale-95 opacity-0 origin-top transition-all duration-150 select-none">
    </div>
</div>
