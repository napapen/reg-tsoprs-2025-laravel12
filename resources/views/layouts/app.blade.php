<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Event Registration')</title>
    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Outfit:wght@100..900&display=swap"
        rel="stylesheet"
    />
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/css/fontawesome.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/css/magnific-popup.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/css/swiper-bundle.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/css/jquery.datetimepicker.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}" />

    <script src="{{ asset('frontend/js/vendor/jquery-3.7.1.min.js') }}"></script>
</head>
<body>
    <header style="background:#eee;padding:10px;">
        <h1>Event Registration</h1>
        <nav>
            <a href="{{ route('home') }}">Home</a> |
            <a href="{{ route('onsite.form') }}">Onsite</a> |
            <a href="{{ route('online.form') }}">Online</a> |
            <a href="{{ route('workshop.form') }}">Workshop</a>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer style="background:#eee;padding:10px;margin-top:20px;">
        <p>&copy; {{ date('Y') }} Event Registration</p>
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