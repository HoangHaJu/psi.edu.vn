@extends('user.layouts.master')
@section('title', __($title))

<head>
				<meta name="description" content="{{ $meta_desc }}">
</head>

@section('content')
				@include('user.layouts.partials.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
				<div class="d-flex justify-content-center align-items-center container bg-white">
								<div class="container gap-64">
												<div class="row">
																<div class="col-12 col-md-4 mb-3">
																				<div class="contact-info mt-4">
																								<h3>Thông tin liên hệ</h3>
																								<p><i class="fa fa-clock-o text-red"></i> Bán hàng: <a style="color: red;"
																																class="d-inline-block">{{ $settingsFooter->where('setting_key', 'footer_open_time')->first()->plain_value }}</a>
																								</p>
																								<p><i class="fa fa-phone text-red"></i> Bán hàng: <a
																																style="color: red;">{{ $settingsFooter->where('setting_key', 'footer_shop_phone')->first()->plain_value }}</a>
																								</p>
																								<p><i class="fa fa-phone text-red"></i> Office: <a
																																style="color: red;">{{ $settingsFooter->where('setting_key', 'footer_office_phone')->first()->plain_value }}</a>
																								</p>
																								<p><i class="fa fa-phone text-red"></i> Bảo hành: <a
																																style="color: red;">{{ $settingsFooter->where('setting_key', 'footer_warranty_phone')->first()->plain_value }}</a>
																								</p>
																								<p>
																												<i class="fa fa-envelope text-red"></i> Hợp tác khiếu nại:
																												<a href="mailto:{{ $settingsFooter->where('setting_key', 'footer_email')->first()->plain_value }}"
																																style="color: red;">{{ $settingsFooter->where('setting_key', 'footer_email')->first()->plain_value }}</a>
																												<br>
																								</p>
																								<p><i class="fa fa-map-marker text-red"></i>
																												{{ $settingsFooter->where('setting_key', 'footer_address')->first()->plain_value }}
																								</p>
																								<span style="color: #02734a;"><a style="color: #02734a;"
																																href="tel:{{ $settingsContact->where('setting_key', 'contact_phone')->first()->plain_value }}">(+84)
																																{{ $settingsContact->where('setting_key', 'contact_phone')->first()->plain_value }}</a></span>
																				</div>
																				<div class="social-media mt-3">
																								<h6>Mạng xã hội</h6>
																								<ul>
																												<li><a target="none"
																																				href="{{ $settingsFooter->where('setting_key', 'footer_social_1')->first()->plain_value }}"><img
																																								width="64" height="64"
																																								src="{{ asset('public/user/assets/images/facebook.png') }}"
																																								class="attachment-full size-full wp-image-6789" alt=""></a></li>
																												<li><a target="none"
																																				href="{{ $settingsFooter->where('setting_key', 'footer_social_2')->first()->plain_value }}"><img
																																								width="64" height="64"
																																								src="{{ asset('public/user/assets/images/linkedin.png') }}"
																																								class="attachment-full size-full wp-image-6790" alt=""></a></li>
																												<li><a target="none"
																																				href="{{ $settingsFooter->where('setting_key', 'footer_social_3')->first()->plain_value }}"><img
																																								width="64" height="64"
																																								src="{{ asset('public/user/assets/images/tiktok.png') }}"
																																								class="attachment-full size-full wp-image-6791" alt=""></a></li>
																								</ul>
																				</div>
																</div>
																<div class="col-12 col-md-8 mb-4">
																				<div class="map me-3 mt-4">
																								<div style="width: 100%"><iframe width="100%" height="400" frameborder="0" scrolling="no"
																																marginheight="0" marginwidth="0"
																																src="https://maps.google.com/maps?width=100%25&amp;height=400&amp;hl=en&amp;q=77%20B%C3%B9i%20T%C3%A1%20H%C3%A1n,%20An%20Ph%C3%BA,%20Th%C3%A0nh%20ph%E1%BB%91%20Th%E1%BB%A7%20%C4%90%E1%BB%A9c+(Mevivu)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"><a
																																				href="https://www.gps.ie/">gps tracker sport</a></iframe></div>
																				</div>
																</div>
												</div>
								</div>
				</div>
@endsection
