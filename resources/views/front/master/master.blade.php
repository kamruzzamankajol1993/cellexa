<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
     <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="{{ $front_ins_name }} -  {{ $front_ins_title }}">
	<meta name="robots" content="">
    <meta name="keywords" content="{{ $front_ins_k }}">
	<meta name="description" content="{{ $front_ins_d }}">
	<meta property="og:title" content="{{ $front_ins_name }} -  {{ $front_ins_title }}">
	<meta property="og:description" content="{{ $front_ins_d }}">
	<meta property="og:image" content="{{ asset('/') }}{{ $front_logo_name }}">
    <!-- Title -->
    <title>@yield('title')</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('/') }}{{ $front_icon_name }}">

    <!-- Google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('/') }}public/front/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('/') }}public/front/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('/') }}public/front/assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="{{ asset('/') }}public/front/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="{{ asset('/') }}public/front/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('/') }}public/front/assets/css/main.css" rel="stylesheet">

    <!-- Load Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

@yield('css')

</head>

<body class="index-page">
    @include('front.include.header')
    @include('front.include.offcanvas')

   @yield('body')
    @include('front.include.footer')

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" xintegrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Vendor JS Files -->
    <script src="{{ asset('/') }}public/front/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('/') }}public/front/assets/vendor/php-email-form/validate.js"></script>
    <script src="{{ asset('/') }}public/front/assets/vendor/aos/aos.js"></script>
    <script src="{{ asset('/') }}public/front/assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="{{ asset('/') }}public/front/assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="{{ asset('/') }}public/front/assets/vendor/purecounter/purecounter_vanilla.js"></script>

    <!-- Main JS File -->
    <script src="{{ asset('/') }}public/front/assets/js/main.js"></script>

    @yield('scripts')

</body>

</html>