<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Event Registration')</title>
    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Outfit:wght@100..900&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/css/fontawesome.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/css/magnific-popup.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/css/swiper-bundle.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/css/jquery.datetimepicker.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}" />

    <script src="{{ asset('frontend/js/vendor/jquery-3.7.1.min.js') }}"></script>
</head>

<body>
    <header style="background:#f0f0f0;" class="text-center py-20">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-4 text-center text-lg-start mb-3 mb-md-0">
                    <a title="APSOPRS Masterclass" href="https://www.apsoprs-thaisoprs2025.com" target="_blank" class="d-block">
                        <img src="https://www.apsoprs-thaisoprs2025.com/assets/frontend/poster-header.png" alt="APSOPRS Masterclass"
                        style="width:100%;max-width:300px"/>
                    </a>
                </div>
                <div class="col-10 col-lg-8 text-center text-lg-end">
                    <h1 class="h6 mb-0">APSOPRS Masterclass in Oculofacial Photography and Videography</h1>
                    <h2 class="h4 mb-0">Sessions Register</h2>
                </div>
            </div>
        </div>
        {{-- <h1>Event Registration</h1>
        <nav>
            <a href="{{ route('home') }}">Home</a> |
            <a href="{{ route('onsite.form') }}">Onsite</a> |
            <a href="{{ route('online.form') }}">Online</a> |
            <a href="{{ route('workshop.form') }}">Workshop</a>
        </nav> --}}
    </header>

    <main >
        @yield('content')
    </main>

    <footer class="footer-wrapper footer-default bg-black2">
        <div class="copyright-wrap bg-gray">
            <div class="container">
                <div class="row gy-2 align-items-center">
                    <div class="col-12">
                        <p class="copyright-text text-white text-center">
                            &copy; {{ date('Y') }} <a href="#">thaisoprs</a>, All rights reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="{{ asset('frontend/js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('frontend/js/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('frontend/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('frontend/js/gsap.min.js') }}"></script>
    <script src="{{ asset('frontend/js/ScrollTrigger.min.js') }}"></script>
    <script src="{{ asset('frontend/js/lenis.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.datetimepicker.min.js') }}"></script>
    <script src="{{ asset('frontend/js/main.js') }}"></script>
</body>

</html>
