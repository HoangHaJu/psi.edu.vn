<div class="row container-fluid container p-0">
				<div id="slide-show" class="container-fluid col-10 p-0">
								<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
												<div class="carousel-inner wrap-slide">
																@foreach ($slider->items as $item)
																				<div class="carousel-item {{ $loop->first ? 'active' : '' }}">
																								<div class="d-flex justify-content-center align-items-center position-relative">
																												<div class="row">
																																<div class="content col-5">
																																				<h2>{{ $item->title }}
																																				</h2>
																																				<h3>{{ $item->sub_title_1 }}
																																				</h3>
																																				<p>{{ $item->sub_title_2 }}
																																				</p>
																																				<p><button onclick="location.href='{{ $item->btn_link }}'" type="button"
																																												class="btn">Mua ngay</button></p>
																																</div>
																																<div
																																				class="image-box d-flex justify-content-center align-items-center position-relative col-7">
																																				<img class="img-fluid" src="{{ asset($item->image) }}" class="d-block"
																																								alt="First Slide">
																																</div>

																												</div>

																								</div>
																				</div>
																@endforeach
												</div>
												<button class="carousel-control-prev slider-button-left" type="button"
																data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
																<i class="fa fa-chevron-left" aria-hidden="true"></i>
												</button>
												<button class="carousel-control-next slider-button-right" type="button"
																data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
																<i class="fa fa-chevron-right" aria-hidden="true"></i>
												</button>
								</div>
								<div class="box-image">
												<img class="img-fluid"
																src="{{ asset($settingsSlider->where('setting_key', 'slider_image_4')->first()->plain_value) }}"
																alt="">
												<img class="img-fluid"
																src="{{ asset($settingsSlider->where('setting_key', 'slider_image_5')->first()->plain_value) }}"
																alt="">
								</div>
				</div>
</div>
