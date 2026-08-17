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

$exactNumericNames = [
    'nipd', 'nisn', 'nik', 'kk_number', 'no_kk', 'rt', 'rw', 'postal_code',
    'phone', 'mobile_phone', 'father_nik', 'mother_nik', 'guardian_nik',
    'npsn', 'nss', 'headmaster_nip', 'tu_head_nip', 'child_order',
    'siblings_count', 'height', 'weight', 'head_circumference',
    'distance_km', 'travel_time_minutes', 'kps_number', 'kks_number',
    'kip_number', 'pip_number'
];

$isNumeric = $type === 'number' || in_array(strtolower($name), $exactNumericNames);
$extraAttrs = $isNumeric ? ['inputmode' => 'numeric', 'min' => '0', 'pattern' => '[0-9]*'] : [];
@endphp

<input 
    type="{{ $type }}" 
    id="{{ $name }}" 
    name="{{ $name }}" 
    value="{{ old($name, $value) }}" 
    autocomplete="one-time-code"
    {{ $attributes->merge(array_merge(['class' => $classes], $extraAttrs)) }}
/>
