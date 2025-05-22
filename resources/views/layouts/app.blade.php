<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DownCare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="#">SPK-Down</a>
    <div class="d-flex">
        @auth
            <a class="btn btn-outline-danger" href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        @else
            <a class="btn btn-outline-primary me-2" href="{{ route('login') }}">Login</a>
            <a class="btn btn-outline-success" href="{{ route('register') }}">Register</a>
        @endauth
    </div>
  </div>
</nav>

@yield('content')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
