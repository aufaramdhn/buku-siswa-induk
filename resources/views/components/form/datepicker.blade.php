@props([
    'name',
    'value' => null,
])

@php
$hasError = $errors->has($name);
$baseClasses = 'w-full pl-4 pr-10 py-2.5 bg-white border border-neutral-200 text-neutral-900 rounded-lg text-sm font-sans focus:border-primary-600 focus:ring-4 focus:ring-primary-600/10 transition-all outline-none';
$errorClasses = 'w-full pl-4 pr-10 py-2.5 bg-white border border-danger text-neutral-900 rounded-lg text-sm font-sans focus:border-danger focus:ring-4 focus:ring-danger/10 transition-all outline-none has-error';
$classes = ($hasError ? $errorClasses : $baseClasses) . ' custom-datepicker-input';

$formattedValue = $value;
if ($value instanceof \DateTime || $value instanceof \Illuminate\Support\Carbon) {
    $formattedValue = $value->format('Y-m-d');
} elseif (is_string($value) && !empty($value)) {
    $formattedValue = date('Y-m-d', strtotime($value));
}
@endphp

<div class="relative w-full custom-datepicker-wrapper" data-name="{{ $name }}">
    <input 
        type="hidden" 
        id="{{ $name }}" 
        name="{{ $name }}" 
        value="{{ old($name, $value ? date('Y-m-d', strtotime($value)) : '') }}"
        class="datepicker-value {{ $hasError ? 'has-error' : '' }}"
        {{ $attributes }}
    />

    <input 
        type="text" 
        name="{{ $name }}_display"
        id="{{ $name }}_display"
        autocomplete="one-time-code"
        class="datepicker-display {{ $classes }}"
        placeholder="dd-mm-yyyy"
        value="{{ old($name . '_display', $formattedValue ? date('d-m-Y', strtotime($formattedValue)) : '') }}"
        {{ $attributes }}
    />
    
    <button 
        type="button" 
        class="datepicker-trigger absolute right-3 top-1/2 -translate-y-1/2 text-neutral-500 hover:text-neutral-800 transition-colors select-none focus:outline-none"
    >
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
    </button>

    <div class="datepicker-calendar dropdown-menu absolute left-0 right-0 mt-1.5 bg-white border border-neutral-200 rounded-xl shadow-lg p-4 z-50 hidden transform scale-95 opacity-0 origin-top transition-all duration-150 select-none w-72">
        <div class="flex items-center justify-between mb-3">
            <button type="button" class="prev-month p-1.5 hover:bg-neutral-50 active:bg-neutral-100 rounded-lg text-neutral-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"></polyline></svg>
            </button>
            <div class="flex items-center gap-1">
                <span class="month-year-label text-sm font-semibold text-neutral-800 font-sans"></span>
            </div>
            <button type="button" class="next-month p-1.5 hover:bg-neutral-50 active:bg-neutral-100 rounded-lg text-neutral-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </button>
        </div>
        
        <div class="grid grid-cols-7 gap-1 text-center mb-1.5">
            <span class="text-[10px] font-bold text-neutral-400 font-sans">Min</span>
            <span class="text-[10px] font-bold text-neutral-400 font-sans">Sen</span>
            <span class="text-[10px] font-bold text-neutral-400 font-sans">Sel</span>
            <span class="text-[10px] font-bold text-neutral-400 font-sans">Rab</span>
            <span class="text-[10px] font-bold text-neutral-400 font-sans">Kam</span>
            <span class="text-[10px] font-bold text-neutral-400 font-sans">Jum</span>
            <span class="text-[10px] font-bold text-neutral-400 font-sans">Sab</span>
        </div>
        
        <div class="days-grid grid grid-cols-7 gap-1">
        </div>

        <div class="flex items-center justify-between border-t border-neutral-100 pt-2.5 mt-2.5">
            <button type="button" class="btn-clear-date text-xs font-semibold text-neutral-500 hover:text-neutral-800 transition-colors font-sans">Hapus</button>
            <button type="button" class="btn-today-date text-xs font-semibold text-blue-600 hover:text-blue-700 transition-colors font-sans">Hari Ini</button>
        </div>
    </div>
</div>
