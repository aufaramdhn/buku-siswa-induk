@props([
    'name',
    'value' => null,
    'rows' => 3,
])

@php
$hasError = $errors->has($name);
$baseClasses = 'w-full px-4 py-2.5 bg-white border border-neutral-200 text-neutral-900 rounded-lg text-sm font-sans focus:border-primary-600 focus:ring-4 focus:ring-primary-600/10 transition-all outline-none resize-none';
$classes = $hasError ? $baseClasses . ' has-error' : $baseClasses;
@endphp

<textarea 
    id="{{ $name }}" 
    name="{{ $name }}" 
    rows="{{ $rows }}"
    autocomplete="one-time-code"
    {{ $attributes->merge(['class' => $classes]) }}
>{{ old($name, $value) }}</textarea>
