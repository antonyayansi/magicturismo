<div class="th-pagination text-center mt-60">
    <ul>
        

        @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
            <li>
                <a class="{{ $page == $paginator->currentPage() ? 'active' : '' }}" href="{{ $url }}">
                    {{ $page }}
                </a>
            </li>
        @endforeach

        @if ($paginator->hasMorePages())
            <li><a class="next-page" href="{{ $paginator->nextPageUrl() }}">Next <img src="{{ asset('assets/img/icon/arrow-right4.svg') }}" alt=""></a></li>
        @else
            <li><a class="next-page" href="javascript:void(0)">Next <img src="{{ asset('assets/img/icon/arrow-right4.svg') }}" alt=""></a></li>
        @endif
    </ul>
</div>
