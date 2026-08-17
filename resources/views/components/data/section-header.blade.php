@props([
    'title',
    'subtitle' => null,
    'backUrl' => null,
])

<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 select-none">
    <div class="flex items-center gap-3">
        @if($backUrl)
            <a 
                href="{{ $backUrl }}" 
                class="w-10 h-10 rounded-xl bg-white border border-neutral-200 flex items-center justify-center text-neutral-600 hover:text-neutral-900 hover:border-neutral-300 transition-all shadow-2xs hover:shadow-xs group flex-shrink-0"
                title="Kembali"
            >
                <svg class="w-5 h-5 transition-transform duration-200 group-hover:-translate-x-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
            </a>
        @endif
        <div class="flex flex-col gap-0.5">
            <h1 class="text-xl sm:text-2xl font-semibold text-neutral-900 tracking-tight font-sans">
                {{ $title }}
            </h1>
            @if($subtitle)
                <p class="text-xs text-neutral-400 font-sans font-normal">
                    {{ $subtitle }}
                </p>
            @endif
        </div>
    </div>

    @if(isset($actions))
        <div class="flex items-center gap-3 w-full sm:w-auto">
            {{ $actions }}
        </div>
    @endif
</div>
