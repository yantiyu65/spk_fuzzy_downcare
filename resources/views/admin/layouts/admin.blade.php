<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') | Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">

    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            background-color: #f4f6f9;
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        .main-sidebar {
            width: 250px;
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #fff;
            border-right: 1px solid #ddd;
            z-index: 1030;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
            border-left: 5px solid #007bff;
            padding-left: 10px;
        }

        .main-footer {
            background-color: #f4f6f9;
            padding: 12px;
            text-align: center;
            border-top: 1px solid #ccc;
            font-size: 0.9rem;
            color: #333;
        }

        @media (max-width: 768px) {
            .main-sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease-in-out;
            }

            .main-sidebar.show {
                transform: translateX(0);
                display: block;
            }

            .main-content {
                margin-left: 0;
                width: 100%;
                padding: 15px;
            }

            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100vh;
                background-color: rgba(0, 0, 0, 0.3);
                z-index: 1040;
            }
        }
    </style>
</head>
<body>

    {{-- Wrapper Utama --}}
    <div class="wrapper">
        @include('admin.layouts.partials.sidebar')

        <div class="main-content">
            <h2 class="section-title">@yield('title')</h2>
            <div class="flex-grow-1">
                @yield('content')
            </div>
        </div>
    </div>

    {{-- Footer di luar wrapper agar full width --}}
    <footer class="main-footer">
        <strong>&copy; 2025 DownCare</strong>
    </footer>

    {{-- Script toggle sidebar --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleBtn = document.querySelector('.sidebar-toggle');
            const sidebar = document.querySelector('.main-sidebar');

            if (toggleBtn) {
                toggleBtn.addEventListener('click', () => {
                    sidebar.classList.toggle('show');
                });
            }
        });
    </script>
</body>
</html>
