<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ระบบลงทะเบียน APSOPRS Masterclass</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('frontend/css/fontawesome.min.css') }}" />
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="#">ระบบลงทะเบียน APSOPRS Masterclass</a>
        <div class="collapse navbar-collapse">
        
        <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link active" href="#">สวัสดี, {{ auth()->user()->name }}</a></li>
            <li class="nav-item"><a href="{{ route('logout') }}" class="btn btn-danger">Logout</a></li>
        </ul>
        </div>
    </div>
</nav>
<header class="border-bottom">  

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid justify-content-center">
        <div class="navbar-nav">
            <a class="btn {{ request()->routeIs('dashboard') ? 'btn-primary' : '' }}" 
            href="{{ route('dashboard') }}">
                หน้าแรก
            </a>
            <a class="btn {{ request()->routeIs('register.list') ? 'btn-primary' : '' }}" 
            href="{{ route('register.list') }}">
                รายการลงทะเบียน
            </a>
        </div>

    </div>
    </nav>


</header>
<main class="py-4 px-4">
    @yield('content')
</main>
<form id="logout-form" action="{{ route('logout') }}" method="POST">
    @csrf
</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>