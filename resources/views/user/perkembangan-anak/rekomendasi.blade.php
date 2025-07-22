@extends('user.layouts.user')
@section('title', 'Rekomendasi Terapi')

@section('content')
<div class="container mt-4">
    <h4 class="mb-3 text-primary fw-bold">Rekomendasi Terapi untuk Anak Anda</h4>
    <p class="text-muted">Berikut adalah rekomendasi terapi berdasarkan hasil analisis perkembangan anak. Rekomendasi dibagi menjadi dua: terapi yang bisa dilakukan <strong>di rumah</strong> dan terapi yang sebaiknya dilakukan <strong>di rumah sakit</strong> dengan bantuan profesional.</p>

    {{-- Rekomendasi Rumah Sakit --}}
    <div class="card mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <span><i class="bi bi-hospital"></i> <strong>Rekomendasi Terapi di Rumah Sakit</strong></span>
            <span class="badge bg-light text-primary">Klinis</span>
        </div>
        <div class="card-body">
            <ul class="mb-0">
                @foreach($rincian['rumah_sakit'] as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
        </div>
    </div>

    {{-- Rekomendasi Rumah --}}
    <div class="card mb-4">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
            <span><i class="bi bi-house-heart"></i> <strong>Rekomendasi Terapi di Rumah</strong></span>
            <span class="badge bg-light text-success">Aktivitas Harian</span>
        </div>
        <div class="card-body">
            <ul class="mb-0">
                @foreach($rincian['rumah'] as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
        </div>
    </div>

    {{-- Tombol Kembali --}}
    <a href="{{ route('user.perkembangan-anak.index') }}" class="btn btn-secondary mb-4"><i class="bi bi-arrow-left-circle"></i> Kembali ke Riwayat</a>

    {{-- DISCLAIMER --}}
    <div class="alert alert-warning" role="alert">
        <h5 class="fw-bold text-warning">⚠️ Catatan Penting</h5>
        <p>
            <strong>Rekomendasi terapi ini bukan pengganti konsultasi dengan profesional medis.</strong> Setiap anak memiliki kebutuhan dan karakteristik yang unik. Hasil ini dihasilkan berdasarkan pendekatan sistem dan tidak serta-merta cocok untuk semua anak.
        </p>
        <p>
            Jika Anda merasa rekomendasi ini <strong>kurang sesuai</strong> atau justru menyebabkan ketidaknyamanan pada anak, <strong>segera hentikan aktivitas</strong> dan konsultasikan ke:
            <ul>
                <li>Terapis Wicara, Okupasi, atau Fisioterapi</li>
                <li>Dokter spesialis tumbuh kembang anak</li>
                <li>Rumah sakit atau layanan tumbuh kembang terdekat</li>
            </ul>
        </p>
        <p>
            Saya sebagai pengembang sistem ini hanyalah manusia biasa. Saya membuat ini bukan untuk menyenangkan semua orang, tapi untuk <strong>membantu</strong>. Kalau sistem ini terasa bermanfaat, <em>Alhamdulillah</em>. Kalau belum tepat, <strong>jangan ragu untuk mencari bantuan yang lebih sesuai.</strong>
        </p>
    </div>

</div>
@endsection
