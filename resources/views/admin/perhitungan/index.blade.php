@extends('admin.layouts.admin')
@section('title', 'Perhitungan Fuzzy')

@section('content')
<div class="container mt-4">
    <form method="GET" action="{{ route('admin.perhitungan') }}" class="row mb-4">
        <div class="col-md-4">
            <label>Filter Nama Anak:</label>
            <select name="anak_id" class="form-control">
                <option value="">-- Semua Anak --</option>
                @foreach($semuaAnak as $anak)
                    <option value="{{ $anak->id }}" {{ request('anak_id') == $anak->id ? 'selected' : '' }}>
                        {{ $anak->nama_anak }} ({{ $anak->created_at->format('d-m-Y') }})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 align-self-end">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </form>

    @if(isset($hasilPerhitungan[0]))
        @php
            $hasil = $hasilPerhitungan[0];
        @endphp

        <div class="card mb-5">
            <div class="card-header bg-primary text-white">
                <strong>{{ $hasil['anak']->nama_anak }}</strong> (Usia: {{ $hasil['anak']->usia_tahun }} tahun) - {{ $hasil['anak']->jenis_kelamin }}
            </div>

            <div id="customCarousel" class="position-relative p-4">
                {{-- Slide 1: Fuzzyfikasi --}}
                <div class="carousel-slide active">
                    <h5>1. Fuzzyfikasi</h5>
                    <div class="table-responsive" style="max-height: 450px; overflow-y: auto;">
                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Kriteria</th>
                                    <th>Subkriteria</th>
                                    <th>Label</th>
                                    <th>Derajat (µ)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($hasil['fuzzyfikasi'] as $fuzzy)
                                    <tr>
                                        <td>{{ $fuzzy['kriteria'] }}</td>
                                        <td>{!! is_array($fuzzy['nama_sub_kriteria']) ? implode('<br>', $fuzzy['nama_sub_kriteria']) : $fuzzy['nama_sub_kriteria'] !!}</td>
                                        <td>{{ $fuzzy['label'] }}</td>
                                        <td>{{ $fuzzy['derajat'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Slide 2: Inferensi --}}
                <div class="carousel-slide">
                    <h5>2. Inferensi</h5>
                    <div class="table-responsive" style="max-height: 450px; overflow-y: auto;">
                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Aturan</th>
                                    <th>IF</th>
                                    <th>THEN</th>
                                    <th>α (min)</th>
                                    <th>Z</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($hasil['inferensi'] as $loopIdx => $inf)
                                    <tr>
                                        <td>R{{ $loopIdx + 1 }}</td>
                                        <td>{{ $inf['if'] }}</td>
                                        <td>{{ $inf['then'] }}</td>
                                        <td>{{ $inf['alpha'] }}</td>
                                        <td>{{ $inf['z'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Slide 3: Defuzzifikasi --}}
                <div class="carousel-slide">
                    <h5>3. Defuzzifikasi</h5>
                    <div class="table-responsive" style="max-height: 400px;">
                        <table class="table table-bordered align-middle">
                            <tr>
                                <th>Σ(α * Z)</th>
                                <td>{{ $hasil['sumAlphaZ'] }}</td>
                            </tr>
                            <tr>
                                <th>Σ(α)</th>
                                <td>{{ $hasil['sumAlpha'] }}</td>
                            </tr>
                            <tr>
                                <th>Z Akhir</th>
                                <td><strong>{{ $hasil['z_akhir'] }}</strong></td>
                            </tr>
                            <tr>
                                <th>Kategori</th>
                                <td><span class="badge bg-info">{{ $hasil['kategori'] }}</span></td>
                            </tr>
                            <tr>
                                <th>Rekomendasi</th>
                                <td>{{ $hasil['rekomendasi'] }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                {{-- Tombol Navigasi --}}
                <div class="d-flex justify-content-center gap-4 mt-3">
                    <button id="prevBtn" class="btn btn-primary rounded-circle" style="width: 50px; height: 50px;">
                        &#8592;
                    </button>
                    <button id="nextBtn" class="btn btn-primary rounded-circle" style="width: 50px; height: 50px;">
                        &#8594;
                    </button>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-info">
            Tidak ada data perhitungan untuk ditampilkan.
        </div>
    @endif
</div>

{{-- Style --}}
<style>
.carousel-slide {
    display: none;
}
.carousel-slide.active {
    display: block;
}
</style>

{{-- Script Carousel --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const slides = document.querySelectorAll('.carousel-slide');
    let currentIndex = 0;

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.classList.toggle('active', i === index);
        });
    }

    document.getElementById('prevBtn').addEventListener('click', function () {
        currentIndex = (currentIndex - 1 + slides.length) % slides.length;
        showSlide(currentIndex);
    });

    document.getElementById('nextBtn').addEventListener('click', function () {
        currentIndex = (currentIndex + 1) % slides.length;
        showSlide(currentIndex);
    });

    showSlide(currentIndex);
});
</script>
@endsection
