@extends('user.layouts.master')
@section('title', __($title))

<head>
				<meta name="description" content="{{ $meta_desc }}">
</head>

@section('content')
				@include('user.layouts.partials.breadcrumbs', ['breadcrumbs' => $breadcrumbs])
				<div class="gap-64" style="width: 100%; position: relative;">
								<div class="banner-information"
												style="background-image: linear-gradient(to bottom, rgba(0,0,0,0.4) 0%,rgba(0,0,0,0.4) 100%), url('{{ asset('public/user/assets/images/bg-about-us.jpg') }}');">
												<div class="banner-content text-white">
																<div class="col-md-6">
																				<h1>
																								<strong>{{ $settingsInformation->where('setting_key', 'infor_title')->first()->plain_value }}</strong>
																				</h1>
																				<p>{{ $settingsInformation->where('setting_key', 'infor_content')->first()->plain_value }}</p>
																				<a href="{{ route('user.contact') }}" class="btn btn-default"><strong>Liên hệ ngay</strong></a>
																</div>
												</div>
												<div style="width: 80%;" class="row flex-section margin-information justify-content-between mb-5">
																<div class="col-4 col-md-12 col-12 mb-3 bg-white shadow">
																				<div style="margin-top: 2rem;"></div>
																				<i
																								class="{{ $settingsInformation->where('setting_key', 'infor_card_icon_1')->first()->plain_value }} info-icon me-3 ms-3"></i>
																				<h4 class="me-3 ms-3 mt-3">
																								{{ $settingsInformation->where('setting_key', 'infor_card_title_1')->first()->plain_value }}
																				</h4>
																				<p class="me-3 ms-3">
																								{{ $settingsInformation->where('setting_key', 'infor_card_content_1')->first()->plain_value }}
																				</p>
																				<a onclick="location.href='{{ route('user.product.saleLimited') }}'"
																								class="btn btn-default mb-4 me-3 ms-3">Xem thêm</a>
																</div>
																<div class="col-4 col-md-12 col-12 mb-3 bg-white shadow">
																				<div style="margin-top: 2rem;"></div>
																				<i
																								class="{{ $settingsInformation->where('setting_key', 'infor_card_icon_2')->first()->plain_value }} info-icon me-3 ms-3"></i>
																				<h4 class="me-3 ms-3 mt-3">
																								{{ $settingsInformation->where('setting_key', 'infor_card_title_2')->first()->plain_value }}
																				</h4>
																				<p class="me-3 ms-3">
																								{{ $settingsInformation->where('setting_key', 'infor_card_content_2')->first()->plain_value }}
																				</p>
																				<a onclick="location.href='{{ route('user.product.saleLimited') }}'"
																								class="btn btn-default mb-4 me-3 ms-3">Xem thêm</a>
																</div>
																<div class="col-4 col-md-12 col-12 mb-3 bg-white shadow">
																				<div style="margin-top: 2rem;"></div>
																				<i
																								class="{{ $settingsInformation->where('setting_key', 'infor_card_icon_3')->first()->plain_value }} info-icon me-3 ms-3"></i>
																				<h4 class="me-3 ms-3 mt-3">
																								{{ $settingsInformation->where('setting_key', 'infor_card_title_3')->first()->plain_value }}
																				</h4>
																				<p class="me-3 ms-3">
																								{{ $settingsInformation->where('setting_key', 'infor_card_content_3')->first()->plain_value }}
																				</p>
																				<a onclick="location.href='{{ route('user.product.saleLimited') }}'"
																								class="btn btn-default mb-4 me-3 ms-3">Xem thêm</a>
																</div>
												</div>
								</div>
				</div>

				<div class="section-gap-default responsive-section bg-white" style="width: 100%">
								<div class="margin-information rounded p-5">
												<div class="row mb-3 mt-5">
																<div class="col-md-12 mt-2 text-center">
																				<h2><strong>TẦM NHÌN</strong></h2>
																				<p class="lead text-secondary">
																								{{ $settingsInformation->where('setting_key', 'infor_vision_content')->first()->plain_value }}
																				</p>
																</div>
												</div>
												<div class="row d-flex justify-content-center flex-wrap">
																<div class="col-md-3 col-12 p-3 text-center" style="border-radius: 5px">
																				<i class="{{ $settingsInformation->where('setting_key', 'infor_vision_icon_1')->first()->plain_value }} fa-3x"
																								style="color: #7AC14A; border: 2px solid #cccccc; border-radius: 50%; padding: 0.8em; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"></i>
																				<p class="mt-5 text-justify">
																								{{ $settingsInformation->where('setting_key', 'infor_vision_text_1')->first()->plain_value }}
																				</p>
																</div>
																<div class="col-md-3 col-12 p-3 text-center" style="border-radius: 5px">
																				<i class="{{ $settingsInformation->where('setting_key', 'infor_vision_icon_2')->first()->plain_value }} fa-3x"
																								style="color: #7AC14A; border: 2px solid #cccccc; border-radius: 50%; padding: 0.8em; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"></i>
																				<p class="mt-5 text-justify">
																								{{ $settingsInformation->where('setting_key', 'infor_vision_text_2')->first()->plain_value }}
																				</p>
																</div>
																<div class="col-md-3 col-12 p-3 text-center" style="border-radius: 5px">
																				<i class="{{ $settingsInformation->where('setting_key', 'infor_vision_icon_3')->first()->plain_value }} fa-3x"
																								style="color: #7AC14A; border: 2px solid #cccccc; border-radius: 50%; padding: 0.8em; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"></i>
																				<p class="mt-5 text-justify">
																								{{ $settingsInformation->where('setting_key', 'infor_vision_text_3')->first()->plain_value }}
																				</p>
																</div>
																<div class="col-md-3 col-12 p-3 text-center" style="border-radius: 5px">
																				<i class="{{ $settingsInformation->where('setting_key', 'infor_vision_icon_4')->first()->plain_value }} fa-3x"
																								style="color: #7AC14A; border: 2px solid #cccccc; border-radius: 50%; padding: 0.8em; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"></i>
																				<p class="mt-5 text-justify">
																								{{ $settingsInformation->where('setting_key', 'infor_vision_text_4')->first()->plain_value }}
																				</p>
																</div>
												</div>
								</div>
				</div>

				<div style="background-image: url('{{ asset('public/user/assets/images/nen1.png') }}'); width: 100%"
								class="responsive-section bg-white text-white">
								<div class="margin-information rounded p-5">
												<div class="row mb-3 mt-5">
																<div class="col-md-12 pt-3 text-center">
																				<h2><strong>SỨ MỆNH</strong></h2>
																				<p><i><u>{{ $settingsInformation->where('setting_key', 'infor_mission_slogan')->first()->plain_value }}</u></i>
																				</p>
																				<p class="lead">
																								{{ $settingsInformation->where('setting_key', 'infor_mission_content')->first()->plain_value }}
																				</p>
																</div>
												</div>

												<div class="row d-flex justify-content-center flex-wrap">
																<div class="col-md-4 col-12 p-3 text-center" style="border-radius: 5px">
																				<i class="{{ $settingsInformation->where('setting_key', 'infor_mission_icon_1')->first()->plain_value }} fa-3x"
																								style="border: 2px solid #cccccc; border-radius: 50%; padding: 0.8em; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"></i>
																				<p class="mt-5 text-justify">
																								{{ $settingsInformation->where('setting_key', 'infor_mission_text_1')->first()->plain_value }}
																				</p>
																</div>
																<div class="col-md-4 col-12 p-3 text-center" style="border-radius: 5px">
																				<i class="{{ $settingsInformation->where('setting_key', 'infor_mission_icon_2')->first()->plain_value }} fa-3x"
																								style="border: 2px solid #cccccc; border-radius: 50%; padding: 0.8em; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"></i>
																				<p class="mt-5 text-justify">
																								{{ $settingsInformation->where('setting_key', 'infor_mission_text_2')->first()->plain_value }}
																				</p>
																</div>
																<div class="col-md-4 col-12 p-3 text-center" style="border-radius: 5px">
																				<i class="{{ $settingsInformation->where('setting_key', 'infor_mission_icon_3')->first()->plain_value }} fa-3x"
																								style="border: 2px solid #cccccc; border-radius: 50%; padding: 0.8em; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"></i>
																				<p class="mt-5 text-justify">
																								{{ $settingsInformation->where('setting_key', 'infor_mission_text_3')->first()->plain_value }}
																				</p>
																</div>
												</div>
								</div>
				</div>

				<div style="background-image: url('{{ asset('public/user/assets/images/nen2.png') }}'); width: 100%"
								class="responsive-section bg-white">
								<div class="margin-information rounded p-5">
												<div class="row mb-3 mt-5">
																<div class="col-md-12 text-center">
																				<h2><strong>GIÁ TRỊ CỐT LÕI</strong></h2>
																				<p class="lead text-start">
																								{{ $settingsInformation->where('setting_key', 'infor_value_content')->first()->plain_value }}
																				</p>
																				<p class="lead text-start">
																								{{ $settingsInformation->where('setting_key', 'infor_value_sub_content')->first()->plain_value }}
																				</p>
																</div>
												</div>

												<div class="row d-flex justify-content-center flex-wrap">
																<div class="col-md-2 col-12 p-3 text-center" style="border-radius: 5px">
																				<i class="{{ $settingsInformation->where('setting_key', 'infor_value_icon_1')->first()->plain_value }} fa-3x"
																								style="color: #7FC84E; border: 2px solid #cccccc; border-radius: 50%; padding: 0.8em; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"></i>
																				<div class="highlight-container">
																								<span
																												class="highlight mt-5">{{ $settingsInformation->where('setting_key', 'infor_value_title_1')->first()->plain_value }}</span>
																				</div>
																				<p class="text-justify">
																								{{ $settingsInformation->where('setting_key', 'infor_value_text_1')->first()->plain_value }}
																				</p>
																</div>
																<div class="col-md-2 col-12 p-3 text-center" style="border-radius: 5px">
																				<i class="{{ $settingsInformation->where('setting_key', 'infor_value_icon_2')->first()->plain_value }} fa-3x"
																								style="color: #7FC84E; border: 2px solid #cccccc; border-radius: 50%; padding: 0.8em; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"></i>
																				<div class="highlight-container">
																								<span
																												class="highlight mt-5">{{ $settingsInformation->where('setting_key', 'infor_value_title_2')->first()->plain_value }}</span>
																				</div>
																				<p class="text-justify">
																								{{ $settingsInformation->where('setting_key', 'infor_value_text_2')->first()->plain_value }}
																				</p>
																</div>
																<div class="col-md-2 col-12 p-3 text-center" style="border-radius: 5px">
																				<i class="{{ $settingsInformation->where('setting_key', 'infor_value_icon_3')->first()->plain_value }} fa-3x"
																								style="color: #7FC84E; border: 2px solid #cccccc; border-radius: 50%; padding: 0.8em; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"></i>
																				<div class="highlight-container">
																								<span
																												class="highlight mt-5">{{ $settingsInformation->where('setting_key', 'infor_value_title_3')->first()->plain_value }}</span>
																				</div>
																				<p class="text-justify">
																								{{ $settingsInformation->where('setting_key', 'infor_value_text_3')->first()->plain_value }}
																				</p>
																</div>
																<div class="col-md-2 col-12 p-3 text-center" style="border-radius: 5px">
																				<i class="{{ $settingsInformation->where('setting_key', 'infor_value_icon_4')->first()->plain_value }} fa-3x"
																								style="color: #7FC84E; border: 2px solid #cccccc; border-radius: 50%; padding: 0.8em; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"></i>
																				<div class="highlight-container">
																								<span
																												class="highlight mt-5">{{ $settingsInformation->where('setting_key', 'infor_value_title_4')->first()->plain_value }}</span>
																				</div>
																				<p class="text-justify">
																								{{ $settingsInformation->where('setting_key', 'infor_value_text_4')->first()->plain_value }}
																				</p>
																</div>
																<div class="col-md-2 col-12 p-3 text-center" style="border-radius: 5px">
																				<i class="{{ $settingsInformation->where('setting_key', 'infor_value_icon_5')->first()->plain_value }} fa-3x"
																								style="color: #7FC84E; border: 2px solid #cccccc; border-radius: 50%; padding: 0.8em; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"></i>
																				<div class="highlight-container">
																								<span
																												class="highlight mt-5">{{ $settingsInformation->where('setting_key', 'infor_value_title_5')->first()->plain_value }}</span>
																				</div>
																				<p class="text-justify">
																								{{ $settingsInformation->where('setting_key', 'infor_value_text_5')->first()->plain_value }}
																				</p>
																</div>
																<div class="col-md-2 col-12 p-3 text-center" style="border-radius: 5px">
																				<i class="{{ $settingsInformation->where('setting_key', 'infor_value_icon_6')->first()->plain_value }} fa-3x"
																								style="color: #7FC84E; border: 2px solid #cccccc; border-radius: 50%; padding: 0.8em; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);"></i>
																				<div class="highlight-container">
																								<span
																												class="highlight mt-5">{{ $settingsInformation->where('setting_key', 'infor_value_title_6')->first()->plain_value }}</span>
																				</div>
																				<p class="text-justify">
																								{{ $settingsInformation->where('setting_key', 'infor_value_text_6')->first()->plain_value }}
																				</p>
																</div>
												</div>
								</div>

								<div class="mt-5 text-center" style="width: 100%;">
												<h2><strong>THÀNH TỰU TUYỆT VỜI</strong></h2>
												<p class="lead">
																{{ $settingsInformation->where('setting_key', 'infor_achievement_content')->first()->plain_value }}
												</p>
								</div>
								<div class="section-percent margin-information text-center">
												<div class="row mt-5 pt-3">
																<div class="col-md-4">
																				<h2><strong>{{ $settingsInformation->where('setting_key', 'infor_achievement_stat_1')->first()->plain_value }}</strong>
																				</h2>
																				<p>
																								{{ $settingsInformation->where('setting_key', 'infor_achievement_text_1')->first()->plain_value }}
																				</p>
																</div>
																<div style="border-left: 1px solid; border-right: 1px solid" class="col-md-4">
																				<h2><strong>{{ $settingsInformation->where('setting_key', 'infor_achievement_stat_2')->first()->plain_value }}</strong>
																				</h2>
																				<p>
																								{{ $settingsInformation->where('setting_key', 'infor_achievement_text_2')->first()->plain_value }}
																				</p>
																</div>
																<div class="col-md-4">
																				<h2><strong>{{ $settingsInformation->where('setting_key', 'infor_achievement_stat_3')->first()->plain_value }}</strong>
																				</h2>
																				<p>
																								{{ $settingsInformation->where('setting_key', 'infor_achievement_text_3')->first()->plain_value }}
																				</p>
																</div>
												</div>
												<div class="row mb-5 mt-3 pb-3">
																<div class="col-md-4">
																				<h2><strong>{{ $settingsInformation->where('setting_key', 'infor_achievement_stat_4')->first()->plain_value }}</strong>
																				</h2>
																				<p>
																								{{ $settingsInformation->where('setting_key', 'infor_achievement_text_4')->first()->plain_value }}
																				</p>
																</div>
																<div style="border-left: 1px solid; border-right: 1px solid" class="col-md-4">
																				<h2><strong>{{ $settingsInformation->where('setting_key', 'infor_achievement_stat_5')->first()->plain_value }}</strong>
																				</h2>
																				<p>
																								{{ $settingsInformation->where('setting_key', 'infor_achievement_text_5')->first()->plain_value }}
																				</p>
																</div>
																<div class="col-md-4">
																				<h2><strong>{{ $settingsInformation->where('setting_key', 'infor_achievement_stat_6')->first()->plain_value }}</strong>
																				</h2>
																				<p>
																								{{ $settingsInformation->where('setting_key', 'infor_achievement_text_6')->first()->plain_value }}
																				</p>
																</div>
												</div>
								</div>
				@endsection
