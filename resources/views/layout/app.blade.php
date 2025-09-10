<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="author" content="themesflat.com">
     <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Modave - POS</title>

    <!-- Theme Style -->
    <link rel="stylesheet" href="{{ asset('css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">

    <!-- Font -->
    <link rel="stylesheet" href="{{ asset('font/fonts.css') }}">

    <!-- Icon -->
    <link rel="stylesheet" href="{{ asset('icon/icomoon/style.css') }}">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/favicon.png') }}">
</head>

<body class="counter-scroll">

    <div id="wrapper">
        <div id="page">
            <div class="layout-wrap loader-off">
                <!-- Preloader -->
                <div id="preload" class="preload-container">
                    <div class="preloading"><span></span></div>
                </div>

                @include('layout.sidebar')
                <div class="section-content-right">
                    @include('layout.header')
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/countto.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('js/apexcharts/apexcharts.js') }}"></script>
    <script src="{{ asset('js/apexcharts/line-chart-1.js') }}"></script>
    <script src="{{ asset('js/lazysize.min.js') }}"></script>
    <script src="{{ asset('js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('js/carousel.js') }}"></script>
    <script src="{{ asset('js/theme-settings.js') }}" defer></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"
        integrity="sha512-pVJzZZzQW7U6U8WmWMCX9gE3D8Rm5Bz6VqN7Z5L4D8wJ7OHnXhX8aY6aIVRQ7zWqUFrYV6cBFKbcQ+TXxjz5xg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</body>

</html>
