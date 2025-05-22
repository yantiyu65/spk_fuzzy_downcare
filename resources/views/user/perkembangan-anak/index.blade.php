@extends('user.layouts.user')
@section('content')
<div class="container mt-4">
    <h4>Riwayat Perkembangan Anak</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Nama Anak</th>
                <th>Usia</th>
                <th>Hasil Diagnosis</th>
                <th>Nilai Defuzzy</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $anak)
            <tr>
                <td>{{ $anak->tanggal }}</td>
                <td>{{ $anak->nama_anak }}</td>
                <td>{{ $anak->usia }}</td>
                <td>{{ $anak->kategori ?? '-' }}</td>
                <td>{{ $anak->nilai_z ?? '-' }}</td>
                <td>
                    <a href="{{ route('user.perkembangan-anak.show', $anak->id) }}" class="btn btn-sm btn-primary">Lihat</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
