@extends('user.layouts.master')
@section('title', __('Chi tiết sản phẩm'))

@push('custom-css')
				<style>
								.review_rating input {
												display: none;
								}

								.review_rating input:checked~label {
												color: #aaa;
								}

								.review_rating label {
												color: orange;
												font-size: 2rem;
								}

								h1 {
												font-family: sans-serif;
												color: #222;
								}
				</style>
@endpush

@section('content')
				@include('user.layouts.partials.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
				<div id="container-sale-off" class="d-flex justify-content-center align-items-center container">
								<div class="container">
												<div class="row">
																<div class="col-md-5 mb-5 mt-5">
																				<div class="position-relative text-center">
																								<x-input name="hidden_avatar" type="hidden" value="{{ asset($product->avatar) }}" />
																								<div class="fotorama" data-nav="thumbs" data-allowfullscreen="true">
																												@foreach ($product->gallery as $item)
																																<img src="{{ asset($item) }}" alt="Product image">
																												@endforeach
																								</div>
																								@if (!isset($product->productVariations[0]))
																												<span
																																class="badge badge-danger position-absolute end-0 top-0 m-3">{{ round(100 - ($product->promotion_price / $product->price) * 100) }}%</span>
																								@else
																												<span
																																class="badge badge-danger position-absolute end-0 top-0 m-3">{{ round(100 - ($product->productVariations[0]->promotion_price / $product->productVariations[0]->price) * 100) }}%</span>
																								@endif
																								@if ($product->is_featured == App\Enums\DefaultActiveStatus::Active)
																												<span class="badge badge-featured position-absolute start-0 top-0 m-3">Nổi bật</span>
																								@endif
																				</div>
																</div>

																<div class="col-md-7 mb-5 mt-5">
																				<div style="border-bottom: 1px solid #f5f5f5" class="row align-items-center">
																								<div class="col-md-8">
																												<h3>{{ $product->name }}</h3>
																												<div class="rating">
																																@for ($i = 1; $i <= $product->avg_rating; $i++)
																																				<span class="star">★</span>
																																@endfor
																																@for ($i = 5; $i > $product->avg_rating; $i--)
																																				<span style="color: gray" class="star">★</span>
																																@endfor
																																<span>{{ $product->reviews->count() }} khách hàng đánh giá</span>
																																<span class="ms-2"><strong> Đã bán:</strong> {{ $product->total_sold }}</span>
																												</div>
																								</div>
																								<div class="col-md-4 justify-content-between align-items-center text-end">
																												<a class="lead" href="https://www.facebook.com/people/BaHa-Group/61559205100698/"><i
																																				class="fa-brands fa-facebook text-black"></i></a>
																												<a class="lead me-2 ms-2" href="https://www.tiktok.com/@baha_group_official"><i
																																				class="fa-brands fa-tiktok text-black"></i></a>
																												<a class="lead"
																																href="https://www.linkedin.com/company/baha-group-joint-stock-company/?viewAsMember=true"><i
																																				class="fa-brands fa-linkedin text-black"></i></a>
																								</div>
																				</div>
																				@if ($product->on_flash_sale)
																								@php
																												$flash_sale = $product->on_flash_sale->details
																												    ->where('product_id', '=', $product->id)
																												    ->first();
																								@endphp
																								<div class="row align-items-center mb-3 ms-1 mt-3">
																												<div class="col-md-8 bg-default h-100 text-center text-white">Kết thúc sau
																																<strong id="countdown-flashsale-product"></strong>
																												</div>
																												<div style="background-color: #f5f5f5;" class="col-md-4 text-center">Đã bán :
																																{{ $flash_sale->sold ?? 0 }}/{{ $flash_sale->qty }}</div>
																								</div>
																				@endif

																				@if (!isset($product->productVariations[0]))
																								<p class="lead">
																												<del>{{ format_price($product->price) }}</del>
																												<strong class="text-red">{{ format_price($product->promotion_price) }}</strong><br>
																												@if (isset($product->on_flash_sale))
																																<span class="flashsale-price"><i class="ti ti-bolt"></i> FLASH SALE
																																				- {{ format_price($product->flashsale_price) }}</span>
																												@endif
																								</p>
																				@else
																								<p id="productDetailPrice" class="lead">
																												<del id="productVariationPrice">{{ format_price($product->productVariations[0]->price) }}</del>
																												<strong id="productVariationPromotionPrice"
																																class="text-red">{{ format_price($product->productVariations[0]->promotion_price) }}</strong><br>
																												@if (isset($product->on_flash_sale))
																																<span class="flashsale-price"><i class="ti ti-bolt"></i> FLASH SALE -
																																				{{ format_price($product->productVariations[0]->flashsale_price) }}</span>
																												@endif
																								</p>
																				@endif

																				<x-input type="hidden" name="hidden_product_id" :value="$product->id" />

																				@if (isset($product->productVariations[0]))
																								<x-input type="hidden" name="hidden_quantity" />
																								<x-input type="hidden" name="hidden_product_variation_id" />
																								@foreach ($product->productAttributes as $item)
																												<div class="row">
																																<div class="col-md-12">
																																				<span>{{ $item->attribute->name }}: <strong
																																												id="attribute_variation_name{{ $item->attribute->id }}">Black</strong></span><br>
																																				<x-input id="hiddenAttribute" type="hidden"
																																								name="attribute_variation_ids[{{ $item->attribute->id }}]" />
																																				<div class="row me-3 mt-2">
																																								@foreach ($item->attributeVariations as $attributeVariation)
																																												@if ($item->attribute->type == App\Enums\Attribute\AttributeType::Color)
																																																<a style="background-color: {{ $attributeVariation->meta_value['color'] }}"
																																																				data-attribute-name="{{ $attributeVariation->name }}"
																																																				data-attribute-id="{{ $item->attribute->id }}"
																																																				data-attribute-variation-id="{{ $attributeVariation->id }}"
																																																				class="col-2 custom-col btn btn-sm square-btn color-btn mb-2 h-16 w-16"></a>
																																												@else
																																																<a data-attribute-name="{{ $attributeVariation->name }}"
																																																				data-attribute-id="{{ $item->attribute->id }}"
																																																				data-attribute-variation-id="{{ $attributeVariation->id }}"
																																																				class="col-2 custom-col btn btn-sm square-btn capacity-btn mb-2 w-5">
																																																				<p class="me-2 ms-2 mt-3">{{ $attributeVariation->name }}</p>
																																																</a>
																																												@endif
																																								@endforeach
																																				</div>
																																</div>
																												</div>
																								@endforeach
																								<span>Trạng thái: <span id="instock"
																																class="text-green">{{ $product->productVariations[0]->qty == 0 ? 'Hết' : 'còn ' . $product->productVariations[0]->qty }}
																																Hàng</span></span>
																								<div class="row mt-3">
																												<div class="col-md-3">
																																<div class="input-group mt-2">
																																				<button disabled id="btnDecrement" class="btn btn-default" type="button"
																																								onclick="decrementDetail()">-</button>
																																				<input readonly onblur="isEnoughQuantity(this)" id="filter-input-detail"
																																								class="form-control text-center" value="1" min="1">
																																				<button disabled id="btnIncrement" class="btn btn-default" type="button"
																																								onclick="incrementDetail()">+</button>
																																</div>
																												</div>
																												<div class="col-md-4"><button id="btnAddToCart" disabled
																																				class="btn btn-default-primary w-100 mt-2"><strong>Thêm vào giỏ hàng</strong></button>
																												</div>
																												<div class="col-md-3"><button id="btnBuyNow" disabled
																																				class="btn btn-default w-100 mt-2"><strong>Mua ngay</strong></button></div>
																								</div>
																				@else
																								<x-input type="hidden" name="hidden_quantity" :value="$product->qty" />
																								<span>Trạng thái: <span
																																class="text-green">{{ $product->qty == 0 ? 'Hết' : 'còn ' . $product->qty }}
																																Hàng</span></span>
																								<div class="row mt-3">
																												<div class="col-md-3">
																																<div class="input-group mt-2">
																																				<button class="btn btn-default" type="button" onclick="decrementDetail()">-</button>
																																				<input onblur="isEnoughQuantity(this)" id="filter-input-detail"
																																								class="form-control text-center" value="1" min="1">
																																				<button class="btn btn-default" type="button" onclick="incrementDetail()">+</button>
																																</div>
																												</div>
																												<div class="col-md-4"><button id="btnAddToCart"
																																				class="btn btn-default-primary w-100 mt-2"><strong>Thêm vào giỏ hàng</strong></button>
																												</div>
																												<div class="col-md-3"><button id="btnBuyNow" class="btn btn-default w-100 mt-2"><strong>Mua
																																								ngay</strong></button></div>
																								</div>
																				@endif
																				<div style="border-top: 1px solid #f5f5f5" class="row mt-5">
																								<p class="mt-2">SKU: {{ $product->sku }}</p>
																								<p>Danh mục:
																												@foreach ($product->categories as $item)
																																<x-link class="text-default" :href="route('user.product.indexUser', ['category_slugs[]' => $item->slug])">{{ $item->name }}</x-link>
																																@if (!$loop->last)
																																				,
																																@endif
																												@endforeach
																								</p>
																				</div>
																</div>
												</div>
								</div>
				</div>
				<div id="container-sale-off" class="d-flex justify-content-center align-items-center container">
								<div class="container">
												<div class="row bg-white">
																<div class="col-12 ms-2 mt-4">
																				<h4>Mô tả sản phẩm</h4>
																				<div class="pe-3 text-justify">
																								{!! $product->desc !!}
																				</div>
																</div>
												</div>
								</div>
				</div>
				<div id="container-sale-off" class="d-flex justify-content-center align-items-center container">
								<div class="container">
												<div class="row bg-white">
																<div class="col-12 ms-3 mt-3">
																				@include('user.products.review')
																</div>
												</div>
								</div>
				</div>
				<div id="container-sale-off" class="d-flex justify-content-center align-items-center container">
								<div class="container">
												<div class="row bg-white">
																<div class="col-12 d-flex align-items-center">
																				<h4 class="mb-3 ms-3 mt-3">Những đánh giá của khách hàng</h4>
																</div>
																<div class="col-12">
																				@foreach ($product->reviews as $review)
																								<div class="d-flex mb-3">
																												<img src="{{ $review->user->avatar ? asset($review->user->avatar) : asset(config('custom.images.default-rating')) }}"
																																alt="Customer Image" class="customer-image me-3">
																												<div class="rating">
																																<strong>{{ $review->user->fullname }}</strong> -
																																{{ format_date_user($review->created_at) }}
																																<br>
																																@for ($i = 1; $i <= $review->rating; $i++)
																																				<span class="star">★</span>
																																@endfor
																																@for ($i = 5; $i > $review->rating; $i--)
																																				<span style="color: gray" class="star">★</span>
																																@endfor
																																<p class="text-justify">{!! $review->content !!}</p>
																												</div>
																								</div>
																				@endforeach
																</div>
												</div>
								</div>
				</div>
				<div id="container-sale-off" class="d-flex justify-content-center align-items-center container">
								<div class="container">
												<div class="row bg-white">
																<div class="col-12 header-box d-flex align-items-center">
																				<h4 class="ms-1 mt-3">Sản phẩm liên quan</h4>
																</div>
																<div class="col-12">
																				<div id="productCarousel-related" class="carousel slide">
																								<div class="carousel-inner">
																												<!-- Slide 1 -->
																												<div class="carousel-item active">
																																<div class="container">
																																				<div class="row">
																																								@foreach ($relatedProducts->take(4) as $relatedProduct)
																																												<div class="col-6 col-md-3 mb-4">
																																																<x-cardproduct :item="$relatedProduct" />
																																												</div>
																																								@endforeach
																																				</div>
																																</div>
																												</div>
																												<!-- Slide 2 -->
																												<div class="carousel-item">
																																<div class="container">
																																				<div class="row">
																																								@foreach ($relatedProducts->skip(4)->take(4) as $relatedProduct)
																																												<div class="col-6 col-md-3 mb-4">
																																																<x-cardproduct :item="$relatedProduct" />
																																												</div>
																																								@endforeach
																																				</div>
																																</div>
																												</div>
																								</div>
																								<button class="carousel-control-prev left-btn-slider-related" type="button"
																												data-bs-target="#productCarousel-related" data-bs-slide="prev">
																												<i class="fa fa-chevron-left" aria-hidden="true"></i>
																								</button>
																								<button class="carousel-control-next right-btn-slider-related" type="button"
																												data-bs-target="#productCarousel-related" data-bs-slide="next">
																												<i class="fa fa-chevron-right" aria-hidden="true"></i>
																								</button>
																				</div>
																</div>
												</div>
								</div>
				</div>
@endsection

@push('custom-js')
				@include('user.products.scripts.scripts')
@endpush
