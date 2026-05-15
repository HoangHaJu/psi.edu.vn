@extends('user.layouts.master')
@section('title', __($title))

<head>
				<meta name="description" content="{{ $meta_desc }}">
</head>

@section('content')
				<div id="content" class="container-fluid d-flex justify-content-center align-items-center">
								<x-slider />
				</div>
				<div class="container mt-3 text-center">
								<img class="img-fluid"
												src="{{ asset($settingsGeneral->where('setting_key', 'banner_home_1')->first()->plain_value) }}"
												alt="HomeBanner1">
				</div>
				<div id="container-category" class="position-relative d-flex mt-3">
								@include('user.home.container-categories')
				</div>
				<div id="container-sale-off" class="position-relative d-flex mt-3">
								@include('user.home.container-sale-off')
				</div>
				<div class="container mt-3 text-center">
								<img class="img-fluid"
												src="{{ asset($settingsGeneral->where('setting_key', 'banner_home_2')->first()->plain_value) }}"
												alt="HomeBanner2">
				</div>

				<x-section />

				<div id="container-sale-off" class="position-relative d-flex mt-3">
								@include('user.home.recommendation')
				</div>

				<div id="container-sale-off" class="position-relative d-flex mt-3">
								@include('user.home.more-info')
				</div>
@endsection
