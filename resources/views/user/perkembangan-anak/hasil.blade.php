@extends('user.layouts.user')
@section('content')
<div class="container mt-4">
    <h4>Hasil Diagnosis Anak</h4>
    
    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Nama Anak:</strong> {{ $data->nama_anak }}</p>
            <p><strong>Usia:</strong> {{ $data->usia }} tahun</p>
            <p><strong>Jenis Kelamin:</strong> {{ $data->jenis_kelamin }}</p>
            <p><strong>Hasil Diagnosis:</strong> <span class="badge bg-info">{{ $data->kategori ?? '-' }}</span></p>
            <p><strong>Nilai Defuzzy:</strong> {{ $data->nilai_z ?? '-' }}</p>
          
        </div>
    </div>

    <a href="{{ route('user.perkembangan-anak.create', ['new' => true]) }}" class="btn btn-secondary">Cek Lagi</a>


    <a href="{{ route('user.perkembangan-anak.index') }}" class="btn btn-primary">Lihat Riwayat</a>
</div>
@endsection
