@if ($paginator->hasPages())
<nav role="navigation" aria-label="Pagination Navigation" style="display: flex; justify-content: space-between; align-items: center; gap: 1rem; flex-wrap: wrap;">
    {{-- Results Info --}}
    <p style="font-size: 0.875rem; color: var(--text-secondary); margin: 0;">
        Showing
        <span style="font-weight: 600; color: var(--text-color);">{{ $paginator->firstItem() ?? 0 }}</span>
        to
        <span style="font-weight: 600; color: var(--text-color);">{{ $paginator->lastItem() ?? 0 }}</span>
        of
        <span style="font-weight: 600; color: var(--text-color);">{{ $paginator->total() }}</span>
        results
    </p>

    {{-- Pagination Links --}}
    <div style="display: flex; align-items: center; gap: 0.25rem;">
        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <span style="display: inline-flex; align-items: center; justify-content: center; width: 2.25rem; height: 2.25rem; border-radius: 0.375rem; border: 1px solid var(--border-color); color: var(--text-secondary); opacity: 0.5; cursor: not-allowed; background: transparent;">
                <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" style="display: inline-flex; align-items: center; justify-content: center; width: 2.25rem; height: 2.25rem; border-radius: 0.375rem; border: 1px solid var(--border-color); color: var(--text-secondary); text-decoration: none; background: var(--card-bg); transition: all 0.15s;" onmouseover="this.style.borderColor='var(--primary-color)';this.style.color='var(--primary-color)';this.style.background='var(--primary-light)'" onmouseout="this.style.borderColor='';this.style.color='';this.style.background='var(--card-bg)'">
                <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
        @endif

        {{-- Page Numbers --}}
        @foreach ($elements as $element)
            {{-- Separator --}}
            @if (is_string($element))
                <span style="display: inline-flex; align-items: center; justify-content: center; width: 2.25rem; height: 2.25rem; font-size: 0.875rem; color: var(--text-secondary);">{{ $element }}</span>
            @endif

            {{-- Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span style="display: inline-flex; align-items: center; justify-content: center; min-width: 2.25rem; height: 2.25rem; padding: 0 0.5rem; border-radius: 0.375rem; background: var(--primary-color); color: white; font-size: 0.875rem; font-weight: 600; box-shadow: 0 1px 3px rgba(79, 70, 229, 0.3);">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" style="display: inline-flex; align-items: center; justify-content: center; min-width: 2.25rem; height: 2.25rem; padding: 0 0.5rem; border-radius: 0.375rem; border: 1px solid var(--border-color); color: var(--text-color); font-size: 0.875rem; font-weight: 500; text-decoration: none; background: var(--card-bg); transition: all 0.15s;" onmouseover="this.style.borderColor='var(--primary-color)';this.style.color='var(--primary-color)';this.style.background='var(--primary-light)'" onmouseout="this.style.borderColor='';this.style.color='';this.style.background='var(--card-bg)'">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" style="display: inline-flex; align-items: center; justify-content: center; width: 2.25rem; height: 2.25rem; border-radius: 0.375rem; border: 1px solid var(--border-color); color: var(--text-secondary); text-decoration: none; background: var(--card-bg); transition: all 0.15s;" onmouseover="this.style.borderColor='var(--primary-color)';this.style.color='var(--primary-color)';this.style.background='var(--primary-light)'" onmouseout="this.style.borderColor='';this.style.color='';this.style.background='var(--card-bg)'">
                <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        @else
            <span style="display: inline-flex; align-items: center; justify-content: center; width: 2.25rem; height: 2.25rem; border-radius: 0.375rem; border: 1px solid var(--border-color); color: var(--text-secondary); opacity: 0.5; cursor: not-allowed; background: transparent;">
                <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        @endif
    </div>
</nav>
@endif
