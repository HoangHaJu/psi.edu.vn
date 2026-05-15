<div class="container">
				<div class="breadcrumb-container pb-3 pt-3">
								<ol class="breadcrumb">
												@foreach ($breadcrumbs as $breadcrumb)
																<li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}">
																				@if (!$loop->last)
																								<x-link :href="$breadcrumb['url']">{{ $breadcrumb['label'] }}</x-link>
																				@else
																								{{ $breadcrumb['label'] }}
																				@endif
																</li>
												@endforeach
								</ol>
				</div>
</div>
