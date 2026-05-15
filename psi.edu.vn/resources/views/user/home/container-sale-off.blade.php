@if (isset($flashSale))
				<div class="rounded-3 container shadow">
								<div class="row">
												<div class="col-12 header-box d-flex align-items-center rounded-top bg-white shadow-sm">
																<h5 class="mb-0">Sản phẩm ưu đãi</h5>
																<div class="timer rounded-3 shadow-sm">
																				<p class="mt-1"><span id="countdown-flashsale-product">216:19:42:02</span></p>
																</div>
												</div>
												<div class="col-12">
																<div id="productCarouselSaleOff" class="carousel slide">
																				<div class="carousel-inner">
																								@foreach ($flashSale->details->chunk(4) as $items)
																												<div class="carousel-item {{ $loop->first ? 'active' : '' }}">
																																<div class="container">
																																				<div class="row">
																																								@foreach ($items as $item)
																																												<div class="col-6 col-md-3">
																																																<x-cardflash :item="$item" />
																																												</div>
																																								@endforeach
																																				</div>
																																</div>
																												</div>
																								@endforeach
																				</div>
																				<button class="carousel-control-prev left-btn-slider" type="button"
																								data-bs-target="#productCarouselSaleOff" data-bs-slide="prev">
																								<i class="fa fa-chevron-left" aria-hidden="true"></i>
																				</button>
																				<button class="carousel-control-next right-btn-slider" type="button"
																								data-bs-target="#productCarouselSaleOff" data-bs-slide="next">
																								<i class="fa fa-chevron-right" aria-hidden="true"></i>
																				</button>
																</div>
												</div>
								</div>
				</div>
@endif

@push('custom-js')
				@include('user.products.scripts.flash-sale-scripts')
@endpush
