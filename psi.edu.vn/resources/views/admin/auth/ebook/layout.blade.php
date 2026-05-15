<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Ebook')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/sach.css') }}">
    @stack('styles')
</head>

<body>
    {{-- Header chung --}}
    <header>
        <div class="d-flex justify-content-center align-items-center mb-3">
            <a class="text-black fs-3 mx-3" href="{{ route('admin.auth.index') }}">Trang chủ</a>
            <div id="multi-language">
                @include('admin.layouts.partials.multi-language')
            </div>
        </div>
        <h1>@yield('header_title', 'Ebook')</h1>
        <p>@yield('header_desc', 'Tải miễn phí ebook tiếng Anh')</p>
    </header>

    {{-- Nội dung chính --}}
    <div class="container">
        @yield('content')
    </div>

    {{-- Footer / popup / load more có thể chung --}}
    @yield('extra')

    {{-- JS chung --}}
    <script src="{{ asset('admin/assets/js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-6Cm2YlJc1q9j0gG4bXTsK8hZ0fX7jH8e6zXk5j5Q5h5j5Q5h5j5Q5h5j5Q5h5j5Q" crossorigin="anonymous">
    </script>
    @stack('scripts')
</body>

</html>
