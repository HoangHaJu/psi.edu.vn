@if ($is_active)
				@php
								$badgeClass = 'bg-green';
								$description = 'Đã duyệt';
				@endphp
@else
				@php
								$badgeClass = 'bg-red';
								$description = 'Chưa duyệt';
				@endphp
@endif

<span class="badge {{ $badgeClass }}">
				{{ $description }}
</span>
