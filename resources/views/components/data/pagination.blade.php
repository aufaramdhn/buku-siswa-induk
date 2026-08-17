@props([
    'paginator',
])

@if ($paginator->hasPages() || $paginator->total() > 0)
    <div id="pagination-container" class="flex flex-col sm:flex-row items-center justify-between px-4 sm:px-6 py-4 gap-3 border-t border-neutral-200 bg-white select-none">
        <div id="pagination-info" class="text-sm text-neutral-500 font-sans text-center sm:text-left">
            @if ($paginator->total() > 0)
                Menampilkan <span class="font-semibold text-neutral-800">{{ $paginator->firstItem() }}</span> – <span class="font-semibold text-neutral-800">{{ $paginator->lastItem() }}</span> dari <span class="font-semibold text-neutral-800">{{ $paginator->total() }}</span> data
            @else
                Tidak ada data untuk ditampilkan
            @endif
        </div>
        
        @if ($paginator->hasPages())
            <div id="pagination-buttons" class="inline-flex items-center justify-center flex-wrap gap-1">
                @if ($paginator->onFirstPage())
                    <span class="px-3 py-1.5 text-sm text-neutral-300 cursor-default select-none font-sans">«</span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" class="font-medium rounded-lg text-sm inline-flex items-center justify-center bg-white text-neutral-700 hover:bg-neutral-50 active:bg-neutral-200 px-3 py-1.5 font-sans pagination-link" data-page="{{ $paginator->currentPage() - 1 }}">«</a>
                @endif

                @php
                    $currentPage = $paginator->currentPage();
                    $lastPage = $paginator->lastPage();
                @endphp

                @if ($lastPage <= 5)
                    @for ($i = 1; $i <= $lastPage; $i++)
                        @if ($i == $currentPage)
                            <span class="font-semibold rounded-lg text-sm inline-flex items-center justify-center bg-blue-600 text-white px-3 py-1.5 font-sans select-none">{{ $i }}</span>
                        @else
                            <a href="{{ $paginator->url($i) }}" class="font-medium rounded-lg text-sm inline-flex items-center justify-center bg-white text-neutral-700 hover:bg-neutral-50 active:bg-neutral-200 px-3 py-1.5 font-sans pagination-link" data-page="{{ $i }}">{{ $i }}</a>
                        @endif
                    @endfor
                @else
                    @if ($currentPage == 1)
                        <span class="font-semibold rounded-lg text-sm inline-flex items-center justify-center bg-blue-600 text-white px-3 py-1.5 font-sans select-none">1</span>
                    @else
                        <a href="{{ $paginator->url(1) }}" class="font-medium rounded-lg text-sm inline-flex items-center justify-center bg-white text-neutral-700 hover:bg-neutral-50 active:bg-neutral-200 px-3 py-1.5 font-sans pagination-link" data-page="1">1</a>
                    @endif

                    @if ($currentPage > 3)
                        <span class="px-2 py-1.5 text-sm text-neutral-400 font-sans select-none">...</span>
                    @endif

                    @php
                        $start = max(2, $currentPage - 1);
                        $end = min($lastPage - 1, $currentPage + 1);
                        
                        if ($currentPage <= 3) {
                            $end = 4;
                        }
                        if ($currentPage >= $lastPage - 2) {
                            $start = $lastPage - 3;
                        }
                    @endphp

                    @for ($i = $start; $i <= $end; $i++)
                        @if ($i == $currentPage)
                            <span class="font-semibold rounded-lg text-sm inline-flex items-center justify-center bg-blue-600 text-white px-3 py-1.5 font-sans select-none">{{ $i }}</span>
                        @else
                            <a href="{{ $paginator->url($i) }}" class="font-medium rounded-lg text-sm inline-flex items-center justify-center bg-white text-neutral-700 hover:bg-neutral-50 active:bg-neutral-200 px-3 py-1.5 font-sans pagination-link" data-page="{{ $i }}">{{ $i }}</a>
                        @endif
                    @endfor

                    @if ($currentPage < $lastPage - 2)
                        <span class="px-2 py-1.5 text-sm text-neutral-400 font-sans select-none">...</span>
                    @endif

                    @if ($currentPage == $lastPage)
                        <span class="font-semibold rounded-lg text-sm inline-flex items-center justify-center bg-blue-600 text-white px-3 py-1.5 font-sans select-none">{{ $lastPage }}</span>
                    @else
                        <a href="{{ $paginator->url($lastPage) }}" class="font-medium rounded-lg text-sm inline-flex items-center justify-center bg-white text-neutral-700 hover:bg-neutral-50 active:bg-neutral-200 px-3 py-1.5 font-sans pagination-link" data-page="{{ $lastPage }}">{{ $lastPage }}</a>
                    @endif
                @endif

                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" class="font-medium rounded-lg text-sm inline-flex items-center justify-center bg-white text-neutral-700 hover:bg-neutral-50 active:bg-neutral-200 px-3 py-1.5 font-sans pagination-link" data-page="{{ $paginator->currentPage() + 1 }}">»</a>
                @else
                    <span class="px-3 py-1.5 text-sm text-neutral-300 cursor-default select-none font-sans">»</span>
                @endif
            </div>
        @endif
    </div>
@endif
