<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('admin.layouts.head')
</head>

<body>
    @php
        $currentUser = auth()->user();
    @endphp
    <div class="page layout">
        <x-admin-sidebar-left />
        @include('admin.layouts.sidebar-top')
        <div class="page-wrapper">
            @section('breadcrumbs')
                @include('admin.layouts.partials.breadcrumbs')
            @show
            @yield('content')
            @include('admin.layouts.footer')
            @include('admin.layouts.modal.modal-logout')
            @include('admin.layouts.modal.modal-delete')
        </div>
    </div>
    @include('admin.layouts.scripts')
    @include('admin.layouts.partials.modal-request-day-off')
    @include('admin.layouts.partials.modal-review')
    @include('admin.layouts.partials.modal-request-cancel')
    <x-alert />

    @if ($currentUser && $currentUser->hasRole('student'))
        <x-floating-contact />
    @endif
</body>

</html>
