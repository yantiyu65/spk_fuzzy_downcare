@extends('user.layouts.user')

@section('content')
<div class="container py-5">
    {{-- Hero Section --}}
    <div class="row align-items-center bg-white p-4 rounded shadow mb-3">
        <div class="col-md-6 mb-3 mb-md-0">
            <h1 class="fw-bold text-primary">DownCare</h1>
            <p class="text-secondary">
                Sistem pendukung perkembangan anak dengan Down Syndrome berbasis web.
                Dirancang untuk mempermudah kolaborasi antara orang tua dan terapis dalam memantau dan mengembangkan potensi anak secara optimal.
            </p>
            <a href="{{ route('login') }}" class="btn btn-primary">Mulai Sekarang</a>
        </div>
        <div class="col-md-6 text-center">
            <img src="{{ asset('images/w1.jpg') }}" class="img-fluid rounded" alt="Ilustrasi Anak-anak Down Syndrome">
        </div>
    </div>

    {{-- Info Section --}}
    <div class="bg-light p-4 rounded mb-5 shadow-sm">
        <h3 class="fw-bold text-dark mb-3">Kenali Down Syndrome Lebih Dalam</h3>
        <p class="text-secondary">
            Down Syndrome adalah kondisi genetik yang memengaruhi perkembangan fisik dan intelektual anak. Anak-anak dengan Down Syndrome memiliki potensi untuk berkembang secara signifikan jika mendapatkan stimulasi dan terapi yang tepat sejak dini.
        </p>
        <p class="text-secondary">
            Terapi yang umum diberikan meliputi: terapi wicara untuk meningkatkan kemampuan komunikasi, fisioterapi untuk memperkuat otot dan koordinasi, serta terapi okupasi untuk melatih kemandirian dalam aktivitas sehari-hari.
        </p>
    </div>

    {{-- Rekomendasi Section --}}
    <div>
        <h4 class="fw-bold text-dark mb-3">Rekomendasi Terapi dan Tips</h4>
        <p class="text-muted">Beberapa rekomendasi dan informasi penting untuk mendukung perkembangan anak Anda.</p>

        <div class="row">
            {{-- Card 1 --}}
            <div class="col-md-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="row g-0 align-items-center">
                        <div class="col-md-4 text-center p-2">
                            <img src="{{ asset('images/w2.jpeg') }}" class="img-fluid rounded" alt="Terapi Wicara">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">Terapi Wicara</h5>
                                <p class="card-text">Membantu anak dalam mengembangkan kemampuan berbicara dan berkomunikasi efektif dengan lingkungan sekitar.</p>
                              
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card 2 --}}
            <div class="col-md-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="row g-0 align-items-center">
                        <div class="col-md-4 text-center p-2">
                            <img src="{{ asset('images/w3.jpeg') }}" class="img-fluid rounded" alt="Fisioterapi">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">Fisioterapi</h5>
                                <p class="card-text">Dirancang untuk meningkatkan kekuatan otot, keseimbangan, dan kemampuan motorik kasar anak.</p>
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
@endsection
