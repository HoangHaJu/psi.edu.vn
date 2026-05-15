@php
				$categoryRepository = app()->make(App\Admin\Repositories\Category\CategoryRepository::class);
				$categories = $categoryRepository->getFlatTree();
				$total = $categories->count();
@endphp
<div class="rounded-3 container bg-white shadow-sm">
				<div class="row header-box">
								<div class="col-12 shadow-sm">
												<h6 class="mb-0">Danh mục nổi bật</h6>
												<x-link class="text-category" :href="route('user.product.indexUser')">{{ __('Tất cả sản phẩm') }}</x-link>
								</div>
				</div>
				<div class="row pt-3">
								@foreach ($categories as $category)
												<div class="col-6 col-md-2 text-center">
																<div class="rounded-3 shadow-sm">
																				<x-link :href="route('user.product.indexUser', ['category_slugs[]' => $category->slug])">
																								<div class="product_avt">
																												<img src="{{ asset($category->avatar) }}" width="100%" />
																								</div>
																				</x-link>
																				<p>
																								<a href="{{ route('user.product.indexUser', ['category_slugs[]' => $category->slug]) }}"
																												class="fs-6 text-dark">
																												{{ $category->name }}
																								</a>
																				</p>
																</div>
												</div>
								@endforeach
				</div>
</div>
