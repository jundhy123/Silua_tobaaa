@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center gap-1">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="pagination-btn disabled">
                <i data-lucide="chevrons-left" class="w-4 h-4"></i>
            </span>
            <span class="pagination-btn disabled hidden sm:flex">
                <i data-lucide="chevron-left" class="w-4 h-4"></i>
            </span>
        @else
            <a href="{{ $paginator->url(1) }}" class="pagination-btn ajax-page-link" rel="prev" title="Halaman Pertama">
                <i data-lucide="chevrons-left" class="w-4 h-4"></i>
            </a>
            <a href="{{ $paginator->previousPageUrl() }}" class="pagination-btn ajax-page-link" rel="prev" title="Sebelumnya">
                <i data-lucide="chevron-left" class="w-4 h-4"></i>
            </a>
        @endif

        {{-- Pagination Elements --}}
        <div class="hidden sm:flex items-center gap-1">
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="px-2 text-gray-400">...</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="pagination-btn active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="pagination-btn ajax-page-link">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        {{-- Mobile Page Info --}}
        <span class="sm:hidden px-4 text-[10px] font-black uppercase tracking-widest text-gray-900">
            Hal {{ $paginator->currentPage() }} dari {{ $paginator->lastPage() }}
        </span>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="pagination-btn ajax-page-link" rel="next" title="Selanjutnya">
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
            </a>
            <a href="{{ $paginator->url($paginator->lastPage()) }}" class="pagination-btn ajax-page-link" rel="next" title="Halaman Terakhir">
                <i data-lucide="chevrons-right" class="w-4 h-4"></i>
            </a>
        @else
            <span class="pagination-btn disabled hidden sm:flex">
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
            </span>
            <span class="pagination-btn disabled">
                <i data-lucide="chevrons-right" class="w-4 h-4"></i>
            </span>
        @endif
    </nav>
@endif
