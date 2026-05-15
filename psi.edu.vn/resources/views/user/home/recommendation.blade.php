<div class="rounded-3 container shadow">
				<div class="row">
								<div class="col-12 header-box d-flex align-items-center rounded-top bg-white shadow-sm">
												<h5 class="mb-0">Sản phẩm dành cho bạn</h5>
								</div>
								<div class="col-12">
												<div id="productCarouselRecommendation" class="carousel slide">
																<div class="carousel-inner">
																				@foreach ($productsRecommendation->chunk(4) as $items)
																								<div class="carousel-item {{ $loop->first ? 'active' : '' }}">
																												<div class="container">
																																<div class="row">
																																				@foreach ($items as $item)
																																								<div class="col-6 col-md-3 mb-3 mt-3">
																																												<x-cardproduct :item="$item" />
																																								</div>
																																				@endforeach
																																</div>
																												</div>
																								</div>
																				@endforeach
																</div>
																<button class="carousel-control-prev left-btn-slider" type="button"
																				data-bs-target="#productCarouselRecommendation" data-bs-slide="prev">
																				<i class="fa fa-chevron-left" aria-hidden="true"></i>
																</button>
																<button class="carousel-control-next right-btn-slider" type="button"
																				data-bs-target="#productCarouselRecommendation" data-bs-slide="next">
																				<i class="fa fa-chevron-right" aria-hidden="true"></i>
																</button>
												</div>
								</div>
				</div>
</div>
