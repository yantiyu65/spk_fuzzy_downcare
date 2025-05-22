<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>@yield('title') | Admin</title>

  <!-- AdminLTE & FontAwesome -->
  <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
      
  <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Tambahan CSS Responsif Sidebar -->
  <style>
      body {
            font-family: 'Poppins', sans-serif !important;
        }
    @media (max-width: 768px) {
      .main-sidebar {
        width: 250px;
        position: fixed;
        top: 0;
        left: 0;
        background-color: #fff;
        border-right: 1px solid #ddd;
        min-height: 100vh;
        transform: translateX(-100%);
        transition: transform 0.3s ease-in-out;
        z-index: 1050;
      }

      .main-sidebar.show {
        transform: translateX(0);
      }

      .sidebar-overlay {
        display: block;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        background-color: rgba(0, 0, 0, 0.3);
        z-index: 1040;
      }
    }

    @media (min-width: 769px) {
      .sidebar-toggle {
        display: none;
      }

      .sidebar-overlay {
        display: none !important;
      }

      .main-sidebar {
        transform: none !important;
        position: fixed;
      }
    }
  </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Toggle Button (mobile only) -->
  <button class="btn btn-primary sidebar-toggle d-md-none m-2" onclick="toggleSidebar()">
    ☰ Menu
  </button>

  <!-- Sidebar Overlay -->
  <div id="sidebarOverlay" class="sidebar-overlay d-none" onclick="toggleSidebar()"></div>

  <!-- Navbar -->
  @include('admin.layouts.partials.navbar')

  <!-- Sidebar -->
  @include('admin.layouts.partials.sidebar')

  <!-- Content -->
  <div class="content-wrapper" style="background-color: #ffffff;">
    <div class="content">
      <div class="container-fluid">
        @yield('content')
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="main-footer text-center">
    <strong>&copy; 2025 DownCare</strong>
  </footer>
</div>

<!-- Bootstrap 5 Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Sidebar Toggle Script -->
<script>
  function toggleSidebar() {
    const sidebar = document.getElementById('mainSidebar');
    const overlay = document.getElementById('sidebarOverlay');
    if (sidebar && overlay) {
      sidebar.classList.toggle('show');
      overlay.classList.toggle('d-none');
    }
  }

  // Tutup sidebar kalau klik menu saat mobile
  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.main-sidebar a').forEach(link => {
      link.addEventListener('click', () => {
        if (window.innerWidth <= 768) {
          document.getElementById('mainSidebar').classList.remove('show');
          document.getElementById('sidebarOverlay').classList.add('d-none');
        }
      });
    });
  });
</script>
</body>
</html>
