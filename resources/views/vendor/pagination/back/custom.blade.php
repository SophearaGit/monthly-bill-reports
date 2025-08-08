<div class="flex items-center gap-x-10">
    <div>
        @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
            <a
                href="{{ $url }}"
                class="btn text-sm h-fit min-h-fit capitalize leading-4 border-0
                    {{ $paginator->currentPage() == $page ? 'bg-color-brands font-semibold' : 'bg-transparent font-semibold text-gray-1100 hover:text-white hover:bg-color-brands dark:text-gray-dark-1100' }}
                    py-[11px] px-[18px]"
            >{{ $page }}</a>
        @endforeach
    </div>
    @if ($paginator->hasMorePages())
        <a
            class="items-center justify-center border rounded-lg border-neutral hidden gap-x-[10px] px-[18px] py-[11px] dark:border-dark-neutral-border sm:flex"
            href="{{ $paginator->nextPageUrl() }}">
            <span class="text-gray-400 text-xs font-semibold leading-[18px] dark:text-gray-dark-400">Next</span>
            <img src="/backend/assets/images/icons/icon-arrow-right-long.svg" alt="arrow right icon">
        </a>
    @endif
</div>
