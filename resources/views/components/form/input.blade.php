@props([
    'name',
    'type' => 'text',
    'value' => null,
])

@php
$hasError = $errors->has($name);
$baseClasses = 'w-full px-4 py-2.5 bg-white border border-neutral-200 text-neutral-900 rounded-lg text-sm font-sans focus:border-primary-600 focus:ring-4 focus:ring-primary-600/10 transition-all outline-none';
$errorClasses = 'w-full px-4 py-2.5 bg-white border border-danger text-neutral-900 rounded-lg text-sm font-sans focus:border-danger focus:ring-4 focus:ring-danger/10 transition-all outline-none has-error';
$classes = $hasError ? $errorClasses : $baseClasses;
@endphp

<input 
    type="{{ $type }}" 
    id="{{ $name }}" 
    name="{{ $name }}" 
    value="{{ old($name, $value) }}" 
    autocomplete="one-time-code"
    {{ $attributes->merge(['class' => $classes]) }}
/>
