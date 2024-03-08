@if ($paginator->hasPages())
    <nav class="d-flex">
        <ul class="pagination pagination-sm pagination-gutter">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item page-indicator disabled">
                    <span class="page-link disabled">
                    <i class="la la-angle-left"></i></span>
                </li>
            @else
                <li class="page-item page-indicator">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}">
                        <i class="la la-angle-left"></i></a>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled">
                        <span class="page-link disabled">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active">
                                <span class="page-link disabled">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item page-indicator">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}">
                        <i class="la la-angle-right"></i></a>
                    </a>
                </li>
            @else
                <li class="page-item page-indicator disabled">
                    <span class="page-link disabled">
                        <i class="la la-angle-right"></i>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif
