@if ($paginator->hasPages())
    <nav class="pagination" role="navigation" aria-label="Paginación">
        @if ($paginator->onFirstPage())
            <span class="disabled" aria-disabled="true">‹</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev">‹</a>
        @endif

        <span class="disabled" aria-disabled="true">
            {{ $paginator->currentPage() }} / {{ $paginator->lastPage() }}
        </span>

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next">›</a>
        @else
            <span class="disabled" aria-disabled="true">›</span>
        @endif
    </nav>
@endif
