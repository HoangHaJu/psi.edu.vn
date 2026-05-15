@extends('user.layouts.master')
@section('title', __($title))

@push('meta')
				<meta name="title" content="{{ $title }}">
				<meta name="description" content="{{ $meta_desc }}" />
@endpush

@section('content')
				@include('user.layouts.partials.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
				<div id="post-container" class="container">
								<div id="postCarousel" class="carousel slide post-carousel" data-bs-ride="carousel">
												<div class="carousel-inner">
																@foreach ($posts->chunk(3) as $key => $chunk)
																				<div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
																								<div class="row">
																												@foreach ($chunk as $post)
																																<div class="col-md-4">
																																				<x-link class="post-wrapper" style="--post-image: url('{{ asset($post->image) }}')"
																																								href="{{ route('user.post.fallback', ['slug' => $post->slug]) }}">
																																								<h1 class="post-title">{{ $post->title }}</h1>
																																								<p style="height: 48px;" class="post-excerpt">{{ $post->excerpt }}</p>
																																								<x-button type="button" class="btn-light post-button">Xem thêm</x-button>
																																				</x-link>
																																</div>
																												@endforeach
																								</div>
																				</div>
																@endforeach
												</div>

												<button class="carousel-control-prev slider-button-left button-post" type="button"
																data-bs-target="#postCarousel" data-bs-slide="prev">
																<i class="fa fa-chevron-left" aria-hidden="true"></i>
												</button>
												<button class="carousel-control-next slider-button-right button-post" type="button"
																data-bs-target="#postCarousel" data-bs-slide="next">
																<i class="fa fa-chevron-right" aria-hidden="true"></i>
												</button>

												<div class="carousel-indicators">
																@foreach ($posts->chunk(3) as $key => $chunk)
																				<button type="button" data-bs-target="#postCarousel" data-bs-slide-to="{{ $key }}"
																								{{ $key == 0 ? 'class=active aria-current=true' : '' }} aria-label="Slide {{ $key + 1 }}">
																				</button>
																@endforeach
												</div>
								</div>
				</div>
@endsection
