<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Event Registration')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
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

    <main style="margin:20px;">
        @yield('content')
    </main>

    <footer style="background:#eee;padding:10px;margin-top:20px;">
        <p>&copy; {{ date('Y') }} Event Registration</p>
    </footer>
</body>
</html>