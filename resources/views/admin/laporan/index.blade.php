@extends('admin.layouts.admin')
@section('title', 'Laporan Perkembangan Anak')

@section('content')
<div class="container">
     <div class="d-flex justify-content-end mb-3 mt-3">
    <a href="{{ route('admin.laporan.cetak') }}" class="btn btn-danger mb-3"><i class="bi bi-printer-fill p-2"></i>Cetak PDF</a>
     </div>
    <div class="table-responsive">
         <table class="table table-bordered table-hover">
        <thead class="table-light">
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
                <td>{{ $item->usia_tahun }}</td>
                <td>{{ $item->jenis_kelamin }}</td>
                <td>{{ $item->kategori }}</td>
                <td>{{ $item->nilai_z }}</td>
                <td>{{ $item->rekomendasi }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
   
</div>
@endsection
