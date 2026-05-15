<div class="card hover-shadow border-0">
				<div class="position-relative">
								<img onclick="location.href='{{ route('user.product.detail', ['slug' => $item->slug]) }}';"
												class="card-img-top img-default" src="{{ asset($item->avatar) }}" style="cursor: pointer;" alt="Product 3">
								<img onclick="location.href='{{ route('user.product.detail', ['slug' => $item->slug]) }}';"
												class="card-img-top img-hover" src="{{ asset($item->gallery[0]) }}" alt="Product 3"
												style="display: none;cursor: pointer;">
								@if ($item->type == \App\Enums\Product\ProductType::Simple)
												<span
																class="badge badge-danger position-absolute end-0 top-0 m-3 text-white">{{ $item->price != 0 ? ceil(100 - ($item->promotion_price * 100) / $item->price) . '%' : '' }}</span>
								@else
												<span
																class="badge badge-danger position-absolute end-0 top-0 m-3 text-white">{{ $item->productVariations[0]->price != 0 ? ceil(100 - ($item->productVariations[0]->promotion_price * 100) / $item->productVariations[0]->price) . '%' : '' }}</span>
								@endif
								<span class="badge badge-featured position-absolute start-0 top-0 m-3">Nổi bật</span>
				</div>
				<div class="card-body">
								<h6 class="card-title mb-1"><x-link class="text-black" :href="route('user.product.detail', ['slug' => $item->slug])">
																{{ $item->name }}
																{{-- @if ($item->on_flash_sale)
																				<span class="badge-flash-sale">
																								<i class="fas fa-bolt flash-icon"></i>
																				</span>
																@endif --}}
												</x-link></h6>
								<div class="rating fs-12">
												@for ($i = 1; $i <= 5; $i++)
																<span class="star" style="color: {{ $i <= $item->avg_rating ? '#ffa200' : '#ccc' }};">★</span>
												@endfor
												<span>{{ $item->reviews->count() }}</span>
								</div>
								@if ($item->type == \App\Enums\Product\ProductType::Simple)
												<p class="text-price"><del>{{ format_price($item->price) }}</del><br><strong
																				class="text-red">{{ format_price($item->promotion_price) }}</strong></p>
												<div class="product-hover text-center">
																<a style="cursor: pointer;" class="add-to-cart">
																				<i onclick="addToCart({{ $item->id }}, '{{ asset($item->avatar) }}')"
																								class="fa fa-shopping-cart w-50" aria-hidden="true"></i><i class="fa fa-arrows-alt w-50"
																								onclick="showDetailProductModal(this, {{ $item->id }})" aria-hidden="true"></i>
																</a>
												</div>
								@else
												<p class="text-price"><strong
																				class="text-red">{{ format_price($item->productVariations()->min('promotion_price')) }}
																				- <br>{{ format_price($item->productVariations()->max('promotion_price')) }}</strong>
												</p>
												<div class="product-hover text-center">
																<a style="cursor: pointer;" class="add-to-cart">
																				<i onclick="location.href='{{ route('user.product.detail', ['slug' => $item->slug]) }}'"
																								class="fa fa-shopping-cart w-50" aria-hidden="true"></i><i class="fa fa-arrows-alt w-50"
																								onclick="showDetailProductModal(this, {{ $item->id }})" aria-hidden="true"></i>
																</a>
												</div>
								@endif
				</div>
</div>
