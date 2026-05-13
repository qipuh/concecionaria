@if ($paginator->hasPages())
    <nav class="d-flex justify-items-center justify-content-between mt-4">
        <div class="d-flex justify-content-between flex-fill d-sm-none">
            <div class="d-flex gap-2">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <button type="button" class="btn btn-sm btn-outline-secondary" disabled>
                        <i class="fas fa-chevron-left"></i> Anterior
                    </button>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-chevron-left"></i> Anterior
                    </a>
                @endif

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="btn btn-sm btn-outline-primary">
                        Siguiente <i class="fas fa-chevron-right"></i>
                    </a>
                @else
                    <button type="button" class="btn btn-sm btn-outline-secondary" disabled>
                        Siguiente <i class="fas fa-chevron-right"></i>
                    </button>
                @endif
            </div>
        </div>

        <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between">
            <div>
                <p class="small text-muted mb-0">
                    Mostrando
                    <span class="fw-semibold">{{ $paginator->firstItem() }}</span>
                    a
                    <span class="fw-semibold">{{ $paginator->lastItem() }}</span>
                    de
                    <span class="fw-semibold">{{ $paginator->total() }}</span>
                    resultados
                </p>
            </div>

            <div>
                <ul class="pagination mb-0">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <li class="page-item disabled" aria-disabled="true">
                            <span class="page-link">
                                <i class="fas fa-chevron-left"></i>
                            </span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </li>
                    @else
                        <li class="page-item disabled" aria-disabled="true">
                            <span class="page-link">
                                <i class="fas fa-chevron-right"></i>
                            </span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
@endif
