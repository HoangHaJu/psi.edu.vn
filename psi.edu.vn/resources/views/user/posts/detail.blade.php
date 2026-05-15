@extends('user.layouts.master')
@section('title', $post->title)

@push('meta')
				<meta name="title" content="{{ $post->meta_title }}">
				<meta name="description" content="{{ $post->excerpt }}" />
@endpush

@section('content')
				@include('user.layouts.partials.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
				<div id="post-detail" class="container">
								<div class="row">
												<div class="col-lg-8 col-md-12">
																<div class="post rounded-2 bg-white shadow">
																				<img class="post-image img-fluid" src="{{ asset($post->image) }}" alt="{{ $post->title }}">
																				<h5 class="post-detail-title">{{ $post->title }}</h5>
																				<!-- <p class="post-date">Đăng vào {{ \Carbon\Carbon::parse($post->posted_at)->format('d/m/Y H:i') }}</p> -->
																				<div class="post-content">{!! $post->content !!}</div>
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
