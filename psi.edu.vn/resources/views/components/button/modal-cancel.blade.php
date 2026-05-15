<button type="button"
				{{ $attributes->class(['btn', 'btn-warning', 'open-modal-cancel'])->merge([
				    'data-bs-toggle' => 'modal',
				    'data-bs-target' => '#modalCancel',
				]) }}>
				@if ($slot->isEmpty())
								<i class="ti ti-cancel"></i>
								<span class="ms-2">{{ $title ?? '' }}</span>
				@else
								<span>{{ $slot }}</span>
				@endif
</button>
