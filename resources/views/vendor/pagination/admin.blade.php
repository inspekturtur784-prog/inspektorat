@if ($paginator->hasPages())
<nav class="adm-pg" role="navigation" aria-label="Pagination">
    <style>
        .adm-pg{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:12px;margin-top:20px;font-size:14px}
        .adm-pg ul{display:flex;gap:6px;list-style:none;margin:0;padding:0;flex-wrap:wrap}
        .adm-pg li a,.adm-pg li span{display:inline-flex;align-items:center;justify-content:center;min-width:36px;height:36px;padding:0 12px;border:1px solid #d9d6cf;border-radius:8px;background:#fff;color:#1f2933;text-decoration:none;line-height:1}
        .adm-pg li a:hover{background:#eef2f7;border-color:#9aa5b1}
        .adm-pg li.active span{background:#0f2a4a;border-color:#0f2a4a;color:#fff;font-weight:600}
        .adm-pg li.disabled span{opacity:.45;cursor:not-allowed}
        .adm-pg .adm-pg-info{color:#6b7280}
    </style>

    <div class="adm-pg-info">
        Menampilkan {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} dari {{ $paginator->total() }} data
    </div>

    <ul>
        @if ($paginator->onFirstPage())
            <li class="disabled"><span>&laquo;</span></li>
        @else
            <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a></li>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="disabled"><span>{{ $element }}</span></li>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active"><span>{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a></li>
        @else
            <li class="disabled"><span>&raquo;</span></li>
        @endif
    </ul>
</nav>
@endif
