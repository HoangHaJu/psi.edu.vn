<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
<meta http-equiv="X-UA-Compatible" content="ie=edge" />
<meta name="X-TOKEN" content="{{ csrf_token() }}">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>@yield('title', 'PSI Education')</title>
<link rel="shortcut icon" type="image/x-icon" href="{{ asset(config('custom.images.favicon')) }}" />
<!-- CSS files -->
<link href="{{ asset('/public/libs/tabler/dist/css/tabler.min.css') }}" rel="stylesheet" />
<link href="{{ asset('/public/libs/jquery-toast-plugin/jquery.toast.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('/public/libs/Parsley.js-2.9.2/style.css') }}" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<link rel="stylesheet" href="{{ asset('/public/assets/css/footer.css') }}">
<link rel="stylesheet" href="{{ asset('/public/assets/css/general.css') }}">
<link rel="stylesheet" href="{{ asset('/public/assets/css/header.css') }}">
<link rel="stylesheet" href="{{ asset('/public/assets/css/reviewCustomer.css') }}">
<link rel="stylesheet" href="{{ asset('/public/assets/css/section3.css') }}">
<link rel="stylesheet" href="{{ asset('/public/assets/css/teacher.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Preahvihear&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Potta+One&display=swap');


    :root {
        --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
    }
</style>


@stack('libs-css')
@stack('custom-css')
