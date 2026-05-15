<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('user.layouts.head')
</head>

<body>
    <div id="root">
        <div id="header" class="container-fluid p-0">
            <x-header />
        </div>
        <div style="position: relative;" class="container-fluid d-flex justify-content-center align-items-center">
            <x-modal-category />
        </div>
        @yield('content')
        <x-bottom-nav />
        <x-footer />
        <x-quickview />
    </div>''
    @include('user.layouts.modal.modal-logout')
    @include('user.scripts.scripts')
    <x-alert />
    @if (!Route::is('user.cart.index') && !Route::is('user.cart.checkout'))
        <x-shoppingcart />
    @endif
</body>

</html>
