@extends('user.layouts.user')
@section('content')
<div class="container mt-4">
    <h4 class="mb-4 text-primary fw-bold">Hasil Evaluasi Perkembangan Anak</h4>

    <div class="card shadow-sm border-0 p-4 mb-4">
        <div class="row mb-2">
            <div class="col-md-4 fw-semibold">Nama Anak:</div>
            <div class="col-md-8">{{ $data->nama_anak }}</div>
        </div>

        <div class="row mb-2">
            <div class="col-md-4 fw-semibold">Usia Anak:</div>
            <div class="col-md-8">{{ $data->usia_tahun ?? '-' }} tahun {{ $data->usia_bulan ?? '-' }} bulan</div>
        </div>

        <div class="row mb-2">
            <div class="col-md-4 fw-semibold">Kategori Stimulus Perkembangan Anak:</div>
            <div class="col-md-8">
                @php
                    $badgeClass = 'bg-secondary';
                    if (str_contains($data->kategori, 'Tinggi')) $badgeClass = 'bg-success';
                    elseif (str_contains($data->kategori, 'Sedang')) $badgeClass = 'bg-warning text-dark';
                    elseif (str_contains($data->kategori, 'Rendah')) $badgeClass = 'bg-danger';
                @endphp
                <span class="badge {{ $badgeClass }}">{{ $data->kategori ?? '-' }}</span>
            </div>
        </div>

        @if (!empty($rentangNormal))
        <div class="row mb-2">
            <div class="col-md-4 fw-semibold">Kemampuan Setara (Estimasi):</div>
            <div class="col-md-8">
                {{ $rentangNormal }} 
                <small class="text-muted d-block">
                    *Estimasi ini bukan patokan mutlak, hanya gambaran umum berdasarkan perkembangan saat ini.
                </small>
            </div>
        </div>
        @endif

        <div class="row mb-2">
            <div class="col-md-4 fw-semibold">Rekomendasi Terapi:</div>
            <div class="col-md-8">
                <blockquote class="blockquote small text-dark bg-light border-start border-3 border-primary ps-3">
                    {{ $data->rekomendasi }}
                </blockquote>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-md-4 fw-semibold">Catatan untuk Orang Tua:</div>
            <div class="col-md-8">
                <div class="fst-italic text-muted small">
                    🧡 {{ $motivasi }}
                </div>
            </div>
        </div>

        <hr class="my-4">

        <div class="alert alert-warning small mb-4">
            <strong>Disclaimer:</strong> Sistem ini dirancang untuk membantu orang tua memantau perkembangan anak, <strong>bukan untuk menggantikan peran dokter, psikolog, atau terapis profesional</strong>.<br>
            Jika Anda merasa rekomendasi kurang tepat atau perkembangan anak tidak sesuai, <strong>segera konsultasikan ke rumah sakit, klinik tumbuh kembang, atau tenaga ahli terpercaya</strong>.
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('user.perkembangan-anak.create', ['new' => true]) }}" class="btn btn-outline-secondary">
                Cek Lagi
            </a>
            <a href="{{ route('user.perkembangan-anak.index') }}" class="btn btn-primary">
                Lihat Riwayat
            </a>
        </div>
    </div>
</div>
@endsection
