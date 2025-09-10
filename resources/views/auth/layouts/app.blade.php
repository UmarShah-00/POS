<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
    <title>Modave - POS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

    <!-- Fonts & Icons -->
    <link rel="stylesheet" href="{{ asset('font/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('icon/icomoon/style.css') }}">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}">
    <link rel="apple-touch-icon-precomposed" href="{{ asset('images/favicon.png') }}">
</head>
<body class="counter-scroll">

    <div id="wrapper">
        <div id="page">
            <div class="layout-wrap loader-off">
                
                <!-- Preloader -->
                <div id="preload" class="preload-container">
                    <div class="preloading"><span></span></div>
                </div>
                <!-- /Preloader -->

                <!-- Main Content -->
                <div class="section-content-right">
                    @yield('content')
                </div>
                <!-- /Main Content -->

            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/countto.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('js/apexcharts/apexcharts.js') }}"></script>
    <script src="{{ asset('js/apexcharts/line-chart-1.js') }}"></script>
    <script src="{{ asset('js/lazysize.min.js') }}"></script>
    <script src="{{ asset('js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('js/carousel.js') }}"></script>
    <script defer src="{{ asset('js/theme-settings.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>

    @yield('script')
</body>
</html>
