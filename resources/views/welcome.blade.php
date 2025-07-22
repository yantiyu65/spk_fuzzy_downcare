@extends('layouts.user')

@section('title', 'DownCare')

@section('content')
<div class="container py-5">
    {{-- Hero Section --}}
    <div class="row align-items-center bg-white p-4 rounded shadow mb-4">
        <div class="col-md-6">
            <h1 class="fw-bold text-primary">DownCare</h1>
            <p class="text-secondary">
                Sistem Pengambilan Keputusan untuk Mendukung Perkembangan Anak Dengan Down Syndrome
            </p>
            <a href="{{ route('login') }}" class="btn btn-primary">Mulai Sekarang</a>
        </div>
        <div class="col-md-6 text-center">
           <img src="{{ asset('images/te.jpg') }}" class="img-fluid rounded" alt="Ilustrasi Anak-anak Down Syndrome" style="max-height: 300px; object-fit: cover;">
        </div>
    </div>

    <div class="bg-light p-4 rounded shadow-sm mb-4">
        <h3 class="fw-bold text-dark mb-3">Apa itu Down Syndrome?</h3>
        <p class="text-secondary">
            <strong>Down Syndrome</strong> adalah kelainan genetik akibat kelebihan kromosom 21, yang berdampak pada perkembangan fisik dan intelektual. Anak-anak dengan Down Syndrome memiliki kebutuhan perkembangan yang spesial, dan intervensi sejak dini sangat penting untuk membantu mereka mencapai potensi maksimal.
        </p>
        <p class="text-secondary">
            Anak-anak dengan Down Syndrome dapat menunjukkan berbagai tingkat perkembangan yang berbeda, yang memerlukan pendekatan yang disesuaikan dengan kemampuan dan tahap tumbuh kembang mereka. Melalui pendekatan yang tepat, mereka dapat berfungsi secara mandiri dan memiliki kualitas hidup yang lebih baik.
        </p>
    </div>

    
    {{-- Fakta Singkat --}}
    <div class="row text-center my-5">
        <div class="col-md-4">
            <h1 class="text-primary fw-bold">6M+</h1>
            <p class="text-muted">Anak dengan Down Syndrome di dunia</p>
        </div>
        <div class="col-md-4">
            <h1 class="text-primary fw-bold">70%</h1>
            <p class="text-muted">Dapat hidup mandiri dengan terapi sejak dini</p>
        </div>
        <div class="col-md-4">
            <h1 class="text-primary fw-bold">3x</h1>
            <p class="text-muted">Lebih besar peluang kemajuan jika didampingi orang tua</p>
        </div>
    </div>

    {{-- Video Edukasi Down Syndrome --}}
    <div class="bg-white p-4 rounded shadow mb-5">
        <h4 class="fw-bold text-dark mb-3">Video Edukasi Down Syndrome</h4>
        <div class="row g-4">
            {{-- Video 1 --}}
            <div class="col-md-6">
                <div class="ratio ratio-16x9 mb-2">
                    <iframe src="https://www.youtube.com/embed/hIsmU0pJwx0" title="Down Syndrome - Penjelasan Umum" allowfullscreen></iframe>
                </div>
                <h6 class="fw-semibold text-dark">Apa Itu Down Syndrome?</h6>
                <p class="text-muted small">Penjelasan umum tentang penyebab, ciri, dan cara penanganan Down Syndrome sejak dini.</p>
            </div>

            {{-- Video 2 --}}
            <div class="col-md-6">
                <div class="ratio ratio-16x9 mb-2">
                    <iframe src="https://www.youtube.com/embed/ikdAfhTrRRA" title="Kisah Anak dengan Down Syndrome" allowfullscreen></iframe>
                </div>
                <h6 class="fw-semibold text-dark">Kisah Nyata Anak Down Syndrome</h6>
                <p class="text-muted small">Cerita inspiratif keluarga dalam mendampingi tumbuh kembang anak dengan Down Syndrome.</p>
            </div>

            {{-- Video 3 --}}
            <div class="col-md-6">
                <div class="ratio ratio-16x9 mb-2">
                    <iframe src="https://www.youtube.com/embed/Rwn67yk8_eM" title="Tips Terapi Anak Down Syndrome di Rumah" allowfullscreen></iframe>
                </div>
                <h6 class="fw-semibold text-dark">Tips Terapi Mandiri di Rumah</h6>
                <p class="text-muted small">Latihan dan terapi sederhana yang bisa dilakukan oleh orang tua di rumah bersama anak.</p>
            </div>

            {{-- Video 4 --}}
            <div class="col-md-6">
                <div class="ratio ratio-16x9 mb-2">
                    <iframe src="https://www.youtube.com/embed/5bvywXf3IzI" title="Wawancara dengan Psikolog Anak" allowfullscreen></iframe>
                </div>
                <h6 class="fw-semibold text-dark">Pandangan Psikolog Anak</h6>
                <p class="text-muted small">Diskusi bersama psikolog mengenai stimulasi emosi, sosial, dan dukungan orang tua.</p>
            </div>
        </div>
    </div>


    {{-- Terapi Section --}}
    <div class="mb-5">
        <h4 class="fw-bold text-dark mb-3">Jenis Terapi Penting</h4>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ asset('images/w2.jpeg') }}" class="img-fluid rounded therapy-img" alt="Terapi Wicara">
                    <div class="card-body">
                        <h5 class="card-title">Terapi Wicara</h5>
                        <p class="card-text">Membantu anak mengembangkan kemampuan berbicara, memahami bahasa, dan berkomunikasi.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ asset('images/w3.jpeg') }}"  class="img-fluid rounded therapy-img" alt="Fisioterapi">
                    <div class="card-body">
                        <h5 class="card-title">Fisioterapi</h5>
                        <p class="card-text">Untuk melatih kekuatan otot, koordinasi tubuh, serta kemampuan motorik kasar.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ asset('images/ok.jpg') }}"  class="img-fluid rounded therapy-img" alt="Terapi Okupasi">
                    <div class="card-body">
                        <h5 class="card-title">Terapi Okupasi</h5>
                        <p class="card-text">Membantu anak melatih kemandirian dalam aktivitas sehari-hari seperti makan, berpakaian, dan bermain.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Kontak Organisasi --}}
    <div class="bg-white p-4 rounded shadow">
        <h4 class="fw-bold text-dark mb-3">Kontak Organisasi dan Layanan Terpercaya</h4>
        <p class="text-secondary">Hubungi organisasi terpercaya berikut untuk informasi dan bantuan lebih lanjut:</p>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <strong>ISDI (Ikatan Sindroma Down Indonesia)</strong><br>
                Website: <a href="https://www.isdi-online.org/" target="_blank">https://www.isdi-online.org</a>
            </li>
            <li class="list-group-item">
                <strong>YAPESDI (Yayasan Peduli Sindroma Down Indonesia)</strong><br>
                Website: <a href="https://yapesdi.or.id" target="_blank">https://yapesdi.or.id</a>
            </li>
            <li class="list-group-item">
                <strong>POTADS (Persatuan Orang Tua Anak dengan Down Syndrome)</strong><br>
                Website: <a href="https://www.potads.or.id" target="_blank">https://www.potads.or.id</a><br>
                Instagram: <a href="https://www.instagram.com/potads_indonesia" target="_blank">@potads_indonesia</a>
            </li>
            <li class="list-group-item">
                <strong>Direktori Terapis Rumah Sakit</strong><br>
                Hubungi poli tumbuh kembang atau bagian rehabilitasi medik di RSUD/RS swasta di wilayah Anda.
            </li>
        </ul>
    </div>
</div>
@endsection
