<link rel="stylesheet" href="{{ asset('user/assets/css/header/header.css') }}">
</style>
<div id="top-bar" class="pb-1 pt-1 shadow-sm">
				<div class="container p-0">
								<p class="fs-12 m-0">Miễn phí vận chuyển trong
												<span class="text-success fw-bold">Ngày của Mevivu.</span>
								</p>
				</div>
</div>
<div id="top-header" class="d-flex align-items-center justify-content-center wrap-nav">
				<div class="container">
								<div class="row pb-2 pt-2">
												<!-- Logo -->
												<div class="col-3 d-flex align-items-center">
																<x-link :href="route('user.index')">
																				<img style="max-height: 80px" class="img-fluid"
																								src="{{ asset($settingsGeneral->where('setting_key', 'site_logo_tab')->first()->plain_value) }}"
																								alt="Mevivu">
																</x-link>
												</div>
												<!-- Search Bar -->
												<div class="col-6 d-flex justify-content-center align-items-center dropdown">
																<div class="input-group dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"
																				data-bs-target="#menu-1">
																				<input type="text" class="form-control" id="search-input"
																								placeholder="Nhập từ khóa bạn muốn tìm kiếm..." aria-label="Text input with dropdown button">
																				<x-button id="search-button" type="button" class="bg-default"><i
																												class="ti ti-search fs-4 text-white"></i></x-button>
																</div>
																<ul class="dropdown-menu" aria-labelledby="dropdownMenuLink" id="menu-pc">
																				<li>
																								<a href="#" class="dropdown-item">
																												<i class="ti ti-search"></i>
																												Nhập từ khóa tìm kiếm...
																								</a>
																				</li>
																</ul>
												</div>
												<!-- Cart Icon -->
												<div class="col-3 d-flex justify-content-center align-items-center">
																@if (!auth('web')->user())
																				<div class="pe- me-5"><a class="top-item text-black" href="{{ route('user.auth.indexUser') }}">Đăng
																												nhập</a></div>
																@else
																				<div class="pe- position-relative me-5">
																								<a class="top-item text-black" href="{{ route('user.profile.indexUser') }}">Hi
																												{{ auth('web')->user()->fullname }}</a>
																								<div class="dropdown-menu" id="userDropdown">
																												<a class="dropdown-item" href="{{ route('user.order.indexUser') }}">Đơn hàng</a>
																												<a class="dropdown-item" href="{{ route('user.profile.indexUser') }}">Tài khoản</a>
																												<a class="dropdown-item" href="{{ route('user.password.indexUser') }}">Mật khẩu</a>
																												<a id="showModal" href="#" class="dropdown-item" data-bs-toggle="modal"
																																data-bs-target="#modalLogout">{{ __('Đăng xuất') }}</a>
																								</div>
																				</div>
																@endif
																<div id="cartButton" class="position-relative">
																				@if (Route::is('user.cart.checkout'))
																								<i onclick="location.href='{{ route('user.cart.index') }}';"
																												style="font-size: 2em;cursor: pointer;" class="fa fa-shopping-cart"></i>
																				@else
																								<i style="font-size: 2em;cursor: pointer;" class="fa fa-shopping-cart"></i>
																				@endif
																				<span id="cart-count"
																								class="position-absolute start-100 translate-middle badge rounded-pill bg-danger top-0"
																								style="left: 100% !important;">
																								@if (auth('web')->user())
																												{{ auth('web')->user()->shopping_cart()->sum('qty') }}
																								@else
																												@php
																																$cart = session()->get('cart', []);
																																$totalQuantity = 0;
																																foreach ($cart as $item) {
																																    $totalQuantity += $item['qty'];
																																}
																												@endphp
																												{{ $totalQuantity }}
																								@endif
																				</span>
																</div>
												</div>
								</div>
				</div>
</div>

<!-- Navbar -->
<div id="navbar" class="">
				<div class="d-flex align-items-center justify-content-center wrap-nav bg-default">
								<div class="row p-m-0 container">
												<!-- Categories Menu -->
												<div style="cursor: pointer; margin-left: -16px" onclick="showTabContent()"
																class="col-3 d-flex align-items-center widget d-none d-xl-flex">
																<h6 class="d-flex align-items-center m-0 text-start" style="height: 45px;">
																				<i class="ti ti-list px-2"></i>Tất cả danh mục
																</h6><br>
																<ul id="menu-1-TQYyg" class="nav-menu"></ul>
												</div>

												<!-- Main Navigation Links -->
												<div class="col-9 d-flex align-items-center d-none d-xl-flex bold-text">
																<ul class="nav">
																				<li class="nav-item default-font-size">
																								<x-link :href="route('user.index')">Trang chủ</x-link>
																				</li>
																				<li class="nav-item default-font-size">
																								<x-link :href="route('user.information')">Giới thiệu</x-link>
																				</li>
																				<li class="nav-item default-font-size">
																								<x-link :href="route('user.product.indexUser')">Sản phẩm</x-link>
																				</li>
																				<li class="nav-item default-font-size">
																								<x-link :href="route('user.contact')">Liên hệ</x-link>
																				</li>
																				<li class="nav-item default-font-size">
																								<x-link :href="route('user.product.saleLimited')">Khuyến mãi giới hạn</x-link>
																				</li>
																				<li class="nav-item default-font-size">
																								<x-link :href="route('user.post.index')">Tin tức</x-link>
																				</li>
																</ul>
												</div>
												<!-- NavBar Responsive-->
												<div class="nav-responsive row d-xl-none d-flex container">
																<button class="col-3 btn d-xl-none d-block text-start" type="button" data-bs-toggle="offcanvas"
																				data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
																				<i class="fa fa-bars default-double-font-size"></i>
																</button>
																<div class="col-6 d-flex justify-content-center align-items-center">
																				<x-link :href="route('user.index')">
																								<img style="max-height: 40px"
																												src="{{ asset($settingsGeneral->where('setting_key', 'site_logo_tab')->first()->plain_value) }}"
																												alt="Mevivu" class="img-fluid">
																				</x-link>
																</div>
																<div class="col-3 d-flex justify-content-center align-items-center cart ps-1">
																				<!-- Cart Icon -->
																				<div class="position-relative me-3">
																								<i onclick="location.href='{{ route('user.cart.index') }}';"
																												style="font-size: 1.8em; cursor: pointer;" class="fa fa-shopping-cart ms-5"></i>
																								<span id="cart-count-mobile"
																												class="position-absolute start-100 translate-middle badge rounded-pill bg-danger top-0"
																												style="left: 100% !important;">
																												@if (auth('web')->user())
																																{{ auth('web')->user()->shopping_cart()->sum('qty') }}
																												@else
																																@php
																																				$cart = session()->get('cart', []);
																																				$totalQuantity = 0;
																																				foreach ($cart as $item) {
																																				    $totalQuantity += $item['qty'];
																																				}
																																@endphp
																																{{ $totalQuantity }}
																												@endif
																								</span>
																				</div>
																</div>

												</div>
												<div class="search-container d-xl-none">
																<form id="searchForm" class="search-form">
																				<input type="text" class="search-input" placeholder="Nhập từ khóa tìm kiếm..."
																								id="search-input-mobile">
																				<button type="button" id="search-button-mobile" class="search-button-mobile">
																								<i class="fa fa-search"></i>
																				</button>
																				<!-- Nút X để xóa text tìm kiếm -->
																				<button type="button" id="clear-search" class="clear-search-button" style="display: none;">
																								<i class="fa fa-times"></i> <!-- Biểu tượng nút X -->
																				</button>
																</form>
																<ul id="search-results" class="list-unstyled"></ul> <!-- Thẻ để chứa kết quả tìm kiếm -->
												</div>
												<!-- Offcanvas Menu -->
												<div class="offcanvas offcanvas-start d-xl-none d-block" tabindex="-1" id="offcanvasExample"
																aria-labelledby="offcanvasExampleLabel">
																<div class="offcanvas-header">
																				<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
																								aria-label="Close"></button>
																</div>
																<div class="offcanvas-body">
																				<ul class="nav nav-tabs" id="myTab" role="tablist">
																								<li class="nav-item" role="presentation">
																												<button class="nav-link active fs-6 bold-text text-black" id="menu-tab"
																																data-bs-toggle="tab" data-bs-target="#menu" type="button" role="tab"
																																aria-controls="menu" aria-selected="true">
																																<i class="ti ti-list"></i> Menu
																												</button>
																								</li>
																								<li class="nav-item" role="presentation">
																												<button class="nav-link fs-6 bold-text text-black" id="category-tab" data-bs-toggle="tab"
																																data-bs-target="#category" type="button" role="tab" aria-controls="category"
																																aria-selected="false">
																																<i class="ti ti-list"></i> Danh mục
																												</button>
																								</li>
																				</ul>
																				<div class="tab-content" id="myTabContent">
																								<div class="tab-pane fade show active" id="menu" role="tabpanel"
																												aria-labelledby="menu-tab">
																												<ul style="margin-top: 0px" class="nav">
																																<li class="nav-item nav-item-menu">
																																				<x-link :href="route('user.index')">Trang chủ</x-link>
																																</li>
																																<li class="nav-item nav-item-menu">
																																				<x-link :href="route('user.information')">Giới thiệu</x-link>
																																</li>
																																<li class="nav-item nav-item-menu">
																																				<x-link :href="route('user.product.indexUser')">Sản phẩm</x-link>
																																</li>
																																<li class="nav-item nav-item-menu">
																																				<x-link :href="route('user.contact')">Liên hệ</x-link>
																																</li>
																																<li class="nav-item nav-item-menu">
																																				<x-link :href="route('user.product.saleLimited')">Khuyến mãi giới hạn</x-link>
																																</li>
																																<li class="nav-item nav-item-menu">
																																				<x-link :href="route('user.post.index')">Tin tức</x-link>
																																</li>
																																@if (!auth('web')->user())
																																				<li class="nav-item nav-item-menu">
																																								<x-link :href="route('user.auth.indexUser')">Đăng nhập</x-link>
																																				</li>
																																@endif
																																@if (auth('web')->user())
																																				<li class="nav-item nav-item-menu">
																																								<x-link :href="route('user.order.indexUser')">Đơn hàng</x-link>
																																				</li>
																																				<li class="nav-item nav-item-menu">
																																								<x-link :href="route('user.profile.indexUser')">Tài khoản</x-link>
																																				<li class="nav-item nav-item-menu">
																																								<x-link :href="route('user.password.indexUser')">Mật khẩu</x-link>
																																				</li>
																																				<li class="nav-item nav-item-menu">
																																								<x-link data-bs-toggle="modal" data-bs-target="#modalLogout"
																																												:href="route('user.product.saleLimited')">Đăng xuất</x-link>
																																				</li>
																																@endif
																												</ul>
																								</div>
																								<div class="tab-pane fade" id="category" role="tabpanel" aria-labelledby="category-tab">
																												<div class="menu-container">
																																<div class="menu-slide">
																																				<div class="menu-panel" id="main-menu">
																																								<ul class="menu">
																																												@foreach ($parentCategories as $category)
																																																<li class="menu-item">
																																																				<a
																																																								href="{{ route('user.product.indexUser', ['category_slugs[]' => $category->slug]) }}">
																																																								<i class="{{ $category->icon }}"></i>
																																																								{{ $category->name }}
																																																				</a>
																																																				@if (isset($category->children[0]))
																																																								<i class="ti ti-chevron-right"
																																																												onclick="showSubMenu('{{ $category->id }}', '{{ $category->name }}')"></i>
																																																				@endif
																																																</li>
																																												@endforeach
																																								</ul>
																																				</div>

																																				<div class="menu-panel" id="submenu">
																																								<p class="back-button" onclick="showMainMenu()">
																																												<i class="ti ti-chevron-left"></i>
																																								</p>
																																								<h3 id="submenu-title" class="mb-3 text-center"></h3>
																																								<ul class="menu" id="submenu-list"></ul>
																																				</div>
																																</div>
																												</div>
																								</div>
																				</div>
																</div>
												</div>
								</div>
				</div>
</div>

<script>
				document.addEventListener('DOMContentLoaded', function() {
								const searchInput = document.getElementById('search-input-mobile');
								const clearButton = document.getElementById('clear-search');

								// Khi người dùng bắt đầu gõ, hiển thị nút X
								searchInput.addEventListener('input', function() {
												if (searchInput.value.length > 0) {
																clearButton.style.display = 'block'; // Hiển thị nút X
												} else {
																clearButton.style.display = 'none'; // Ẩn nút X nếu không có nội dung
												}
								});

								// Khi người dùng nhấn nút X, xóa nội dung và ẩn nút X
								clearButton.addEventListener('click', function() {
												searchInput.value = ''; // Xóa nội dung ô tìm kiếm
												clearButton.style.display = 'none'; // Ẩn nút X
												menu = $('#search-results');
												menu.html('');
								});
				});
</script>

<button onclick="topFunction()" id="backToTopBtn" title="Go to top">
				<img src="{{ asset('public/user/assets/images/up-arrow.png') }}" alt="Back to Top"
								style="width: 48px; height: 48px;">
</button>

<script src="{{ asset('public/user/assets/js/back-to-top-btn.js') }}"></script>
