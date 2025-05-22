@extends('admin.layouts.admin')
@section('title', 'Laporan')

@section('content')
<div class="container mt-4">
    <h4>Laporan Perkembangan Anak</h4>
    <a href="{{ route('admin.laporan.cetak') }}" class="btn btn-danger mb-3">Cetak PDF</a>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Anak</th>
                <th>Usia</th>
                <th>Jenis Kelamin</th>
                <th>Diagnosis</th>
                <th>Nilai Z</th>
                <th>Rekomendasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
            <tr>
                <td>{{ $item->nama_anak }}</td>
                <td>{{ $item->usia }}</td>
                <td>{{ $item->jenis_kelamin }}</td>
                <td>{{ $item->kategori }}</td>
                <td>{{ $item->nilai_z }}</td>
                <td>{{ $item->rekomendasi }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
