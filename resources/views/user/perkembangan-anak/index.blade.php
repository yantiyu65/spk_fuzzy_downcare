@extends('user.layouts.user')
@section('content')
<div class="container mt-4">

    <h4 class="mb-4 text-primary fw-bold">Riwayat Perkembangan Anak</h4>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($data->count() > 0)
    <!-- Tombol Toggle -->
    <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-outline-primary btn-sm" id="toggleChartBtn">Tampilkan Grafik</button>
    </div>

    <!-- Judul dan Chart (disembunyikan dulu) -->
    <div id="chartContainer" class="card shadow-sm mb-4" style="display: none;">
        <div class="card-header bg-white fw-semibold" id="chartTitle" style="display: none;">
            Visualisasi Stimulus Perkembangan Anak
        </div>
        <div class="card-body">
            <canvas id="perkembanganChart" height="100"></canvas>
        </div>
    </div>
    @endif

    {{-- TABEL RIWAYAT (default tampil) --}}
    <div class="card shadow-sm" id="tableContainer">
        <div class="card-body p-3">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-primary">
                    <tr>
                        <th>Tanggal</th>
                        <th>Nama Anak</th>
                        <th>Usia</th>
                        <th>Stimulus</th>
                        <th>Nilai Z</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $anak)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($anak->tanggal)->format('d M Y') }}</td>
                        <td class="fw-semibold text-secondary">{{ $anak->nama_anak }}</td>
                        <td>{{ $anak->usia_tahun ?? '-' }} tahun {{ $anak->usia_bulan ?? '-' }} bulan</td>
                        <td>
                            @if($anak->kategori)
                                <span class="badge bg-info text-dark">{{ $anak->kategori }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $anak->nilai_z ?? '-' }}</td>
                        <td class="text-center">
                            <a href="{{ route('user.perkembangan-anak.show', $anak->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i> Lihat
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            Belum ada riwayat perkembangan anak yang tercatat.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if($data->count() > 0)
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const chartContainer = document.getElementById('chartContainer');
    const chartTitle = document.getElementById('chartTitle');
    const tableContainer = document.getElementById('tableContainer');
    const toggleBtn = document.getElementById('toggleChartBtn');

    let showingChart = false;

    toggleBtn.addEventListener('click', () => {
        showingChart = !showingChart;

        chartContainer.style.display = showingChart ? 'block' : 'none';
        chartTitle.style.display = showingChart ? 'block' : 'none';
        tableContainer.style.display = showingChart ? 'none' : 'block';

        toggleBtn.textContent = showingChart ? 'Tampilkan Tabel' : 'Tampilkan Grafik';
    });

    const ctx = document.getElementById('perkembanganChart').getContext('2d');

    const dataChart = {
        labels: @json($data->pluck('tanggal')->map(fn($tgl) => \Carbon\Carbon::parse($tgl)->format('d M'))),
        datasets: [{
            label: 'Nilai Stimulus (Z)',
            data: @json($data->pluck('nilai_z')),
            fill: true,
            borderColor: 'rgba(0, 123, 255, 1)',
            backgroundColor: 'rgba(0, 123, 255, 0.2)',
            tension: 0.4,
            pointRadius: 5,
            pointBackgroundColor: 'rgba(0, 123, 255, 1)'
        }]
    };

    const configChart = {
        type: 'line',
        data: dataChart,
        options: {
            responsive: true,
            scales: {
                y: {
                    min: 1,
                    max: 5,
                    ticks: {
                        stepSize: 1,
                        callback: function(value) {
                            if (value == 1) return 'Rendah';
                            if (value == 3) return 'Sedang';
                            if (value == 5) return 'Tinggi';
                            return '';
                        }
                    },
                    title: {
                        display: true,
                        text: 'Kategori Stimulus'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Tanggal Pemeriksaan'
                    }
                }
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const z = context.raw;
                            let kategori = z <= 2 ? 'Rendah' : (z <= 4 ? 'Sedang' : 'Tinggi');
                            return `Stimulus: ${kategori} (Z = ${z})`;
                        }
                    }
                }
            }
        }
    };

    new Chart(ctx, configChart);
</script>

@endif
@endsection
