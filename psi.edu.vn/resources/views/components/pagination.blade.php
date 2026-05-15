@if ($paginator->hasPages())
				<!-- Nút Previous -->
				<button class="pagination-btn prev" onclick="location.href='{{ $paginator->previousPageUrl() }}'"
								@if ($paginator->onFirstPage()) disabled @endif>
								<i class="ti ti-arrow-left" aria-hidden="true"></i>
				</button>

				<!-- Nút phân trang -->
				@for ($i = 1; $i <= $paginator->lastPage(); $i++)
								<button onclick="location.href='{{ $paginator->url($i) }}'"
												class="pagination-btn @if ($i == $paginator->currentPage()) active @endif">
												{{ $i }}
								</button>
				@endfor

				<!-- Nút Next -->
				<button class="pagination-btn next" onclick="location.href='{{ $paginator->nextPageUrl() }}'"
								@if (!$paginator->hasMorePages()) disabled @endif>
								<i class="ti ti-arrow-right" aria-hidden="true"></i>
				</button>
@endif
