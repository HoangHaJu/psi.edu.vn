<style>
				.post-title {
								margin: 0px !important;
				}

				.post-date {
								margin: 0px !important;
				}
</style>
<div id="related-post">
				<h5 class="title">
								{{ isset($relatedPosts) && $relatedPosts->isNotEmpty() ? 'Bài viết liên quan' : 'Bài viết khác' }}
				</h5>
				<div class="row">
								@foreach ($relatedPosts ?? $otherPosts as $post)
												<x-link class="post-item" href="{{ route('user.post.fallback', ['slug' => $post->slug]) }}">
																<h1 class="post-title">{{ $post->title }}</h1>
																<p class="post-date">Đăng vào {{ \Carbon\Carbon::parse($post->posted_at)->format('d/m/Y H:i') }}</p>
																<img class="post-image" src="{{ asset($post->image) }}" alt="{{ $post->title }}">
												</x-link>
								@endforeach
				</div>
</div>
