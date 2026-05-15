<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    @include('admin.layouts.guest.head')

</head>

<body>
    @php
        $currentUser = auth()->user();
    @endphp
    @yield('content')
    @include('admin.layouts.guest.footer')
    @include('admin.layouts.guest.scripts')

    <x-alert />
    <x-floating-contact />
</body>

</html>
