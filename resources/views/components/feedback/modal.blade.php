@props([
    'id',
    'size' => 'max-w-md',
])

<div 
    id="{{ $id }}" 
    class="modal-backdrop fixed inset-0 bg-neutral-900/50 z-50 flex items-center justify-center p-4 transition-opacity duration-100 ease-out opacity-0 pointer-events-none"
>
    <div class="modal-card bg-white rounded-xl w-full {{ $size }} p-6 shadow-xl border border-neutral-100 transform scale-95 transition-transform duration-100 ease-out">
        {{ $slot }}
    </div>
</div>
