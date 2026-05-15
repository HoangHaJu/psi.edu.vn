@extends('user.layouts.master')
@section('title', __($title))

<head>
				<meta name="description" content="{{ $meta_desc }}">
</head>

@section('content')
				@include('user.layouts.partials.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
				<div id="container-sale-off" class="d-flex justify-content-center align-items-center container">
								<div class="container gap-64">
												<div class="row">
																<div class="col-12 text-center"><img class="img-fluid"
																								src="{{ asset('user/assets/images/bg-flash-sale.jpg') }}" alt="">
																</div>
																<div class="col-12 header-box d-flex align-items-center">
																				<h4>Khuyến mãi giới hạn</h4>
																				<div class="timer">
																								<p class="mt-1"><span id="countdown-flashsale-product">0 Giờ : 0 Phút : 0 Giây</span></p>
																				</div>
																</div>
																<div class="col-12">
																				<div class="row">
																								@if ($products)
																												@foreach ($products as $item)
																																<div class="col-6 col-md-3 mb-2 mt-2">
																																				<x-cardflash :item="$item" />
																																</div>
																												@endforeach
																								@endif
																				</div>

																				<div class="pagination w-100 d-flex justify-content-center bottom-0 mb-0 mt-3">
																								@if ($products)
																												{{ $products->links('components.pagination') }}
																								@endif
																				</div>
																</div>
												</div>
								</div>
				</div>
@endsection
@push('custom-js')
				@include('user.products.scripts.flash-sale-scripts')
@endpush
