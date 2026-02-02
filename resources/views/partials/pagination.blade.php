@if ($paginator->hasPages())
    <nav class="pagination" role="navigation" aria-label="Paginación">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="disabled" aria-disabled="true" title="Página anterior">‹</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" title="Página anterior">‹</a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="disabled" aria-disabled="true">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="active" aria-current="page">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" title="Página siguiente">›</a>
        @else
            <span class="disabled" aria-disabled="true" title="Página siguiente">›</span>
        @endif
    </nav>
@endif
