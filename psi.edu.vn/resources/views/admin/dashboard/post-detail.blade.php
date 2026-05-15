@extends('admin.layouts.master')

<link rel="stylesheet" href="{{ asset('admin/assets/css/dashboard.css') }}">
<style>
				.post-detail-container {
								padding: 24px;
								background: #ffffff;
								border-radius: 8px;
								box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
				}

				.post-header {
								margin-bottom: 24px;
								border-bottom: 1px solid #eee;
								padding-bottom: 16px;
				}

				.post-meta {
								margin: 16px 0;
				}

				.meta-item {
								padding: 8px 16px;
								background: #f8f9fa;
								border-radius: 4px;
								margin-bottom: 8px;
				}

				.post-image {
								max-width: 100%;
								height: auto;
								margin: 16px 0;
								border-radius: 4px;
				}

				.post-content {
								line-height: 1.6;
								margin-top: 24px;
				}

				.categories-list {
								display: flex;
								flex-wrap: wrap;
								gap: 8px;
				}

				.category-item {
								padding: 4px 12px;
								background: #e9ecef;
								border-radius: 16px;
								font-size: 13px;
				}
</style>

@section('content')
				<div class="container-fluid">
								<div class="row">
												<div class="col-12">
																<div class="post-detail-container">
																				<!-- Post Header -->
																				<div class="post-header">
																								<h1>{{ $post->title }}</h1>
																				</div>

																				<!-- Post Image -->
																				@if ($post->image)
																								<div class="text-center">
																												<img src="{{ asset($post->image) }}" alt="{{ $post->title }}" class="post-image">
																								</div>
																				@endif

																				<!-- Post Excerpt -->
																				@if ($post->excerpt)
																								<div class="post-excerpt">
																												<h5>Tóm tắt:</h5>
																												<div class="meta-item">
																																{{ $post->excerpt }}
																												</div>
																								</div>
																				@endif

																				<!-- Post Content -->
																				@if ($post->content)
																								<div class="post-content">
																												<h5>Nội dung:</h5>
																												{!! $post->content !!}
																								</div>
																				@endif
																</div>
												</div>
								</div>
				</div>
@endsection
