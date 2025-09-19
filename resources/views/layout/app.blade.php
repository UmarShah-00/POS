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

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer">

    <!-- Font -->
    <link rel="stylesheet" href="{{ asset('font/fonts.css') }}">

    <!-- Icon -->
    <link rel="stylesheet" href="{{ asset('icon/icomoon/style.css') }}">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/favicon.png') }}">

    <!-- ✅ Scroll Fix CSS -->
    <style>
        /* पूरे page पर scroll allow */
        html,
        body {
            height: auto !important;
            min-height: 100vh !important;
            overflow-y: auto !important;
            /* vertical scroll force */
            overflow-x: hidden !important;
            /* horizontal scroll hide */
        }

        /* wrapper elements par bhi scroll allow */
        #wrapper,
        #page,
        .layout-wrap,
        .section-content-right {
            min-height: 100vh !important;
            overflow-y: auto !important;
            overflow-x: hidden !important;
            position: relative !important;
        }
    </style>

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

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- jQuery CDN (backup) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Font Awesome JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>

</body>

</html>
