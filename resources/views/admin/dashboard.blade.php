@extends('admin.layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container py-4">
  <div class="row">
    <div class="col-md-3">
      <a href="{{ route('admin.datauser') }}" class="text-decoration-none">
        <div class="card bg-primary text-white text-center mb-3">
          <div class="card-body">
            <p class="card-text">Total Users</p>
            <h5 class="card-title mt-2">{{ $totalUser }}</h5>
          </div>
        </div>
      </a>
    </div>

    <div class="col-md-3">
      <a href="{{ route('admin.kriteria') }}" class="text-decoration-none">
        <div class="card bg-warning text-white text-center mb-3">
          <div class="card-body">
            <p class="card-text">Total Kriteria</p>
            <h5 class="card-title mt-2">{{ $totalKriteria }}</h5>
          </div>
        </div>
      </a>
    </div>

    <div class="col-md-3">
      <a href="{{ route('admin.subkriteria') }}" class="text-decoration-none">
        <div class="card bg-danger text-white text-center mb-3">
          <div class="card-body">
            <p class="card-text">Total Sub Kriteria</p>
            <h5 class="card-title mt-2">{{ $totalSubKriteria }}</h5>
          </div>
        </div>
      </a>
    </div>
  </div>

  <div class="row mt-4">
    <div class="col-md-6 mb-4">
      <div class="card">
        <div class="card-header bg-success text-white">
          <strong>Diagram Usia Pengguna</strong>
        </div>
        <div class="card-body">
          <div style="position: relative; height: 350px; width: 100%;">
            <canvas id="usiaChart"></canvas>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-6 mb-4">
      <div class="card">
        <div class="card-header bg-info text-white">
          <strong>Diagram Tahapan Anak</strong>
        </div>
        <div class="card-body">
          <div style="position: relative; height: 350px; width: 100%;">
            <canvas id="tahapanChart"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

  const usiaLabels = {!! json_encode(array_keys($usiaCounts)) !!};
  const usiaData = {!! json_encode(array_values($usiaCounts)) !!};


  const ctx = document.getElementById('usiaChart').getContext('2d');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: usiaLabels,
      datasets: [{
        label: 'Jumlah Pengguna',
        data: usiaData,
        backgroundColor: 'rgba(75, 192, 192, 0.7)',
        borderColor: 'rgba(75, 192, 192, 1)',
        borderWidth: 1,
        borderRadius: 6,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      animation: false,
      hover: { mode: null },
      plugins: {
        legend: { display: false }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: { stepSize: 1 }
        }
      }
    }
  });

  const tahapanLabels = {!! json_encode(array_keys($tahapanCounts)) !!};
  const tahapanData = {!! json_encode(array_values($tahapanCounts)) !!};

  const ctx2 = document.getElementById('tahapanChart').getContext('2d');
  new Chart(ctx2, {
    type: 'doughnut',
    data: {
      labels: tahapanLabels,
      datasets: [{
        label: 'Jumlah Anak Berdasarkan Tahapan',
        data: tahapanData,
        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'],
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      animation: false,
      hover: { mode: null },
      plugins: {
        legend: { display: false }
      }
    }
  });
</script>
@endsection
