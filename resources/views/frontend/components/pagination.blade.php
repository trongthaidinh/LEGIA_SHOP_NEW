@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('pagination.navigation') }}" class="flex items-center justify-center space-x-2 my-4">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="px-4 py-2 text-gray-400 cursor-not-allowed rounded-md bg-gray-100">
                <i class="fas fa-chevron-left"></i>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" 
               class="px-4 py-2 text-[var(--color-primary-600)] hover:bg-[var(--color-primary-50)] rounded-md transition-colors">
                <i class="fas fa-chevron-left"></i>
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="px-4 py-2 text-gray-600">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span aria-current="page" 
                              class="px-4 py-2 bg-[var(--color-primary-600)] text-white rounded-md">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" 
                           class="px-4 py-2 text-[var(--color-primary-600)] hover:bg-[var(--color-primary-50)] rounded-md transition-colors">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" 
               class="px-4 py-2 text-[var(--color-primary-600)] hover:bg-[var(--color-primary-50)] rounded-md transition-colors">
                <i class="fas fa-chevron-right"></i>
            </a>
        @else
            <span class="px-4 py-2 text-gray-400 cursor-not-allowed rounded-md bg-gray-100">
                <i class="fas fa-chevron-right"></i>
            </span>
        @endif
    </nav>
@endif
