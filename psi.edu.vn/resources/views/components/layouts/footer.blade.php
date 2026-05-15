<x-floating-contact />
<div id="footer" class="bg-white">
				<div class="container">
								<div class="row d-flex justify-content-center">
												<div class="col-md-4 col-12 box">
																<h6><strong>Liên hệ</strong></h6>
																<p><i class="fa-solid fa-clock text-red"></i> Bán hàng: <a class="text-red"
																								class="d-inline-block">{{ $settingsFooter->where('setting_key', 'footer_open_time')->first()->plain_value }}</a>
																</p>
																<p><i class="fa fa-phone text-red"></i> Bán hàng: <a
																								class="text-red">{{ $settingsFooter->where('setting_key', 'footer_shop_phone')->first()->plain_value }}</a>
																</p>
																<p><i class="fa fa-phone text-red"></i> Office: <a
																								class="text-red">{{ $settingsFooter->where('setting_key', 'footer_office_phone')->first()->plain_value }}</a>
																</p>
																<p><i class="fa fa-phone text-red"></i> Bảo hành: <a
																								class="text-red">{{ $settingsFooter->where('setting_key', 'footer_warranty_phone')->first()->plain_value }}</a>
																</p>
																<p>
																				<i class="fa fa-envelope text-red"></i> Hợp tác khiếu nại:
																				<a href="mailto:{{ $settingsFooter->where('setting_key', 'footer_email')->first()->plain_value }}"
																								class="text-red">{{ $settingsFooter->where('setting_key', 'footer_email')->first()->plain_value }}</a>
																				<br>
																</p>
																<p><i class="fa fa-map-marker text-red"></i>
																				{{ $settingsFooter->where('setting_key', 'footer_address')->first()->plain_value }}
																</p>
																<span style="color: #02734a;"><a style="color: #02734a;"
																								href="tel:{{ $settingsFooter->where('setting_key', 'footer_phone')->first()->plain_value }}">(+84)
																								{{ $settingsFooter->where('setting_key', 'footer_phone')->first()->plain_value }}</a></span>
												</div>
												<div class="col-md-4 col-12 box">
																<h6><strong>Hỗ trợ</strong></h6>
																<ul>
																				<li><a href="{{ $settingsFooter->where('setting_key', 'privacy_policy')->first()->plain_value }}">Chính
																												sách bảo mật</a></li>
																				<li><a
																												href="{{ $settingsFooter->where('setting_key', 'operating_regulations')->first()->plain_value }}">Quy
																												chế hoạt động</a></li>
																				<li><a href="{{ $settingsFooter->where('setting_key', 'shipping_policy')->first()->plain_value }}">Chính
																												sách vận chuyển</a></li>
																				<li><a
																												href="{{ $settingsFooter->where('setting_key', 'return_and_refund_policy')->first()->plain_value }}">Chính
																												sách trả hàng và hoàn tiền</a></li>
																</ul>
												</div>
												<div class="col-md-4 col-12 box">
																<h6><strong>Mạng xã hội</strong></h6>
																<ul>
																				<li><a target="none"
																												href="{{ $settingsFooter->where('setting_key', 'footer_social_1')->first()->plain_value }}">
																												<img width="64" height="64"
																																src="{{ asset('public/user/assets/images/facebook.png') }}"
																																class="attachment-full size-full wp-image-6789" alt=""> Facebook</a></li>
																				<li><a target="none"
																												href="{{ $settingsFooter->where('setting_key', 'footer_social_2')->first()->plain_value }}">
																												<img width="64" height="64"
																																src="{{ asset('public/user/assets/images/linkedin.png') }}"
																																class="attachment-full size-full wp-image-6790" alt=""> Linkedin</a></li>
																				<li><a target="none"
																												href="{{ $settingsFooter->where('setting_key', 'footer_social_3')->first()->plain_value }}">
																												<img width="64" height="64"
																																src="{{ asset('public/user/assets/images/tiktok.png') }}"
																																class="attachment-full size-full wp-image-6791" alt=""> Tiktok</a></li>
																</ul>
												</div>
								</div>
								<div id="footerCategory" class="custom-line mt-2">
												@foreach ($parentCategories as $parentCategory)
																<div class="col-md-3 col-12 box">
																				<p style="cursor: pointer"
																								onclick="location.href='{{ route('user.product.indexUser', ['category_slugs[]' => $parentCategory->slug]) }}'">
																								<strong>{{ $parentCategory->name }}</strong>
																				</p>
																				<p class="text-777777 small mt-2 text-justify">
																								@foreach ($parentCategory->children as $children)
																												<x-link class="text-777777" :href="route('user.product.indexUser', ['category_slugs[]' => $children->slug])">{{ $children->name }}</x-link>
																												@if (!$loop->last)
																																|
																												@endif
																												@foreach ($children->children as $item)
																																<x-link class="text-777777" :href="route('user.product.indexUser', ['category_slugs[]' => $item->slug])">{{ $item->name }}</x-link>
																																@if (!$loop->last)
																																				|
																																@endif
																												@endforeach
																								@endforeach
																				</p>
																</div>
												@endforeach
								</div>
								<div id="endFooter" class="col-12 custom-line mt-3 pb-3">
												<p><strong>Mevivu</strong> tự hào mang đến cho bạn một trải nghiệm mua sắm công nghệ tuyệt vời. Chúng tôi là
																địa điểm tốt nhất để bạn khám phá và tìm hiểu về những xu hướng công nghệ mới nhất, cũng như tìm mua các
																sản phẩm công nghệ hàng đầu.</p>
												<div style="color: #74818E" class="col-12 text-center">
																© Copyright <strong style="color: #444444">Mevivu</strong> All Rights Reserved<br>
																Designed by <a style="color: #5FB3E4" href="https://thietkeweb.mevivu.com/">Mevivu</a>
												</div>
								</div>
				</div>
</div>
