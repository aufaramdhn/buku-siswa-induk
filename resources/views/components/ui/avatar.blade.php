@props([
    'name',
])

@php
$words = explode(' ', preg_replace('/\s+/', ' ', trim($name)));
$initials = '';
if (count($words) >= 2) {
    $initials = strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
} elseif (count($words) > 0 && !empty($words[0])) {
    $initials = strtoupper(substr($words[0], 0, min(2, strlen($words[0]))));
} else {
    $initials = '??';
}
@endphp

<div {{ $attributes->merge(['class' => 'w-9 h-9 rounded-full bg-neutral-100 flex items-center justify-center text-xs font-semibold text-neutral-700 select-none border border-neutral-200']) }}>
    {{ $initials }}
</div>
