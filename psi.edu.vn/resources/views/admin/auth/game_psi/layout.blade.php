<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Trò chơi - Listen and Choose')</title>

    {{-- Font & CSS --}}
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/mucluc.css') }}">

    @stack('styles')
    <style>
        #multi-language {
            width: 100%;
            display: flex;
            justify-content: center;
        }
    </style>
</head>

<body>
    <div id="multi-language">
        @include('admin.layouts.partials.multi-language')
    </div>
    <div class="container-game">
        @yield('content')
    </div>

    @stack('scripts')
</body>

</html>
