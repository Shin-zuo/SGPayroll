@if ($paginator->hasPages())
    <ul class="admin-pagination-links">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="disabled"><span class="paginate_button disabled"><i class="fa fa-chevron-left text-[10px] mr-1"></i> Prev</span></li>
        @else
            <li><a href="{{ $paginator->previousPageUrl() }}" class="paginate_button" rel="prev"><i class="fa fa-chevron-left text-[10px] mr-1"></i> Prev</a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="disabled"><span class="paginate_button disabled">{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active"><span class="paginate_button current">{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url }}" class="paginate_button">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}" class="paginate_button" rel="next">Next <i class="fa fa-chevron-right text-[10px] ml-1"></i></a></li>
        @else
            <li class="disabled"><span class="paginate_button disabled">Next <i class="fa fa-chevron-right text-[10px] ml-1"></i></span></li>
        @endif
    </ul>
@endif
