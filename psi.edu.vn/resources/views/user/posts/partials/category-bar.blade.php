<div id="category-bar">
				<h5 class="title">Chuyên mục</h5>
				<div class="category-list">
								<x-link class="category-item" href="{{ route('user.post.index') }}">
												{{ __('Tất cả') }}
								</x-link>
								@foreach ($categories as $category)
												@if ($category->status == '1')
																<x-link class="category-item" href="{{ route('user.post.fallback', ['slug' => $category->slug]) }}">
																				<p class="category-name">{{ $category->name }}</p>
																</x-link>
												@endif
								@endforeach
				</div>
</div>
