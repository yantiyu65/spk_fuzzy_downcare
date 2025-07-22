<aside id="mainSidebar" class="main-sidebar sidebar-light-primary elevation-1 d-flex flex-column">

  <div class="sidebar p-3 text-center">
    <!-- Sidebar Header -->
    <div class="d-flex align-items-center mb-3 ps-2">
      <img src="/images/logo1.png" alt="Profile" class="rounded-circle me-2" width="65" height="65">
      <div>
        <h6 class="mb-0 fw-bold mx-2">DownCare</h6>
        <small class="text-muted">Admin</small>
      </div>
    </div>

    <!-- Navigasi -->
    <div class="sidebar p-3">
      <a href="{{ route('admin.dashboard') }}" class="btn btn-light w-100 d-flex align-items-center mb-2 text-start">
        <i class="bi bi-house-door-fill me-2"></i><span class="mx-4">Dashboard</span>
      </a>
      <a href="{{ route('admin.perhitungan') }}" class="btn btn-light w-100 d-flex align-items-center mb-2 text-start">
        <i class="bi bi-calculator-fill me-2"></i><span class="mx-4">Perhitungan</span>
      </a>
      <a href="{{ route('admin.kriteria') }}" class="btn btn-light w-100 d-flex align-items-center mb-2 text-start">
        <i class="bi bi-sliders2-vertical me-2"></i><span class="mx-4">Kriteria</span>
      </a>
      <a href="{{ route('admin.laporan') }}" class="btn btn-light w-100 d-flex align-items-center mb-2 text-start">
        <i class="bi bi-file-earmark-bar-graph-fill me-2"></i><span class="mx-4">Laporan</span>
      </a>
      <a href="{{ route('admin.datauser') }}" class="btn btn-light w-100 d-flex align-items-center mb-2 text-start">
        <i class="bi bi-people-fill me-2"></i><span class="mx-4">Data User</span>
      </a>

      <!-- Logout -->
      <form method="POST" action="{{ route('logout') }}" class="mt-2">
        @csrf
        <button type="submit" class="btn btn-light w-100 d-flex align-items-center mb-2 text-start">
          <i class="bi bi-box-arrow-right me-2"></i><span class="mx-4">Logout</span>
        </button>
      </form>
    </div>
  </div>
</aside>
