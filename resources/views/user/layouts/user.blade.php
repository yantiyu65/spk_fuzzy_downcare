<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'DownCare')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <style>
        body {
            font-family: 'Poppins', sans-serif !important;
        }
        .navbar-brand img {
            width: 50px;
        }
    
        .navbar-nav .nav-link {
            position: relative;
            padding-bottom: 5px;
            color: #000;
            transition: color 0.3s ease;
        }
    
        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            height: 2px;
            width: 0;
            background-color: #007bff; /* biru Bootstrap */
            transition: width 0.3s ease;
        }
    
        .navbar-nav .nav-link:hover::after {
            width: 100%;
        }
        .therapy-img {
    transition: transform 0.4s ease, box-shadow 0.4s ease;
    border-radius: 10px;
    }

    .therapy-img:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
    }

    </style>
    
</head>
<body class="d-flex flex-column min-vh-100"> 
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('images/logo.png') }}" alt="Logo"> DownCare
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/user/dashboard') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.perkembangan-anak.create') }}">Cek</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.rekomendasi') }}">Rekomendasi</a>
                    </li>
                
                    @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                @endguest
                
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                @endauth
                
                </ul>
                
            </div>
        </div>
    </nav>

    <!-- Konten Halaman -->
    <div class="container my-3">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="bg-light text-center py-3 mt-auto">
        <small>© {{ date('Y') }} DownCare - All Rights Reserved</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
