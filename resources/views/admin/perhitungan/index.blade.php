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
    @foreach($hasilPerhitungan as $hasil)
    <div class="card mb-5">
        <div class="card-header bg-primary text-white">
            <strong>{{ $hasil['anak']->nama_anak }}</strong> (Usia: {{ $hasil['anak']->usia }}) - {{ $hasil['anak']->jenis_kelamin }}
        </div>
        <div class="card-body">
            

            <h5>1. Fuzzyfikasi</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Kriteria</th>
                        <th>Nilai</th>
                        <th>Label</th>
                        <th>Derajat (µ)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($hasil['fuzzyfikasi'] as $fuzzy)
                    <tr>
                        <td>{{ $fuzzy['kriteria'] }}</td>
                        <td>{{ $fuzzy['nama_sub_kriteria'] }}</td>
                        <td>{{ $fuzzy['label'] }}</td>
                        <td>{{ $fuzzy['derajat'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <h5>2. Inferensi</h5>
            <table class="table table-bordered">
                <thead>
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

            <h5>3. Defuzzifikasi</h5>
            <table class="table table-bordered">
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
    @endforeach

</div>
@endsection
