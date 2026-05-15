@extends('user.layouts.master')
@section('title', $category->name)

@push('meta')
				<meta name="title" content="{{ $category->name }}">
				<meta name="description" content="{{ $category->name }}" />
@endpush

<link rel="stylesheet" href="{{ asset('user/assets/css/posts/post-category.css') }}">

@section('content')
				@include('user.layouts.partials.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
				<div id="category-post" class="container">
								<div class="row">
												<div class="col-lg-8 col-md-12">
																@if ($posts->isEmpty())
																				<h5>Chưa có bài viết nào thuộc mục này.</h5>
																@endif
																@foreach ($posts as $post)
																				<div class="post-wrapper rounded-2 mb-4 bg-white shadow">
																								<x-link href="{{ route('user.post.fallback', ['slug' => $post->slug]) }}">
																												<img class="post-image" src="{{ asset($post->image) }}" alt="{{ $post->title }}">
																												<h1 class="post-category-title">{{ $post->title }}</h1>
																								</x-link>
																								<p class="post-excerpt">{{ $post->excerpt }}</p>
																								<div class="post-bottom">
																												<x-link type="button" class="btn btn-light post-button"
																																href="{{ route('user.post.fallback', ['slug' => $post->slug]) }}">Đọc tiếp</x-link>
																												<p class="post-date">Đăng vào {{ \Carbon\Carbon::parse($post->posted_at)->format('d/m/Y H:i') }}
																												</p>
																								</div>
																				</div>
																@endforeach
																<div class="pagination w-100 d-flex justify-content-center bottom-0 mb-0 mt-3">
																				{{ $posts->links('components.pagination') }}
																</div>
												</div>
												<div class="col-lg-4 col-md-12">
																<div class="rounded-2 bg-white shadow">
																				@include('user.posts.partials.category-bar')
																</div>
																<div class="rounded-2 bg-white shadow">
																				@include('user.posts.partials.related-post')
																</div>
												</div>
								</div>
				</div>
@endsection
