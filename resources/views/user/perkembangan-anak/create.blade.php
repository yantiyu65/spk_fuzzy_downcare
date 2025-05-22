@extends('user.layouts.user')
@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Form Cek Perkembangan Anak</h3>

    <form action="{{ route('user.perkembangan-anak.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Nama Anak</label>
            <input type="text" name="nama_anak" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Usia</label>
            <input type="number" name="usia" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Jenis Kelamin</label>
            <select name="jenis_kelamin" class="form-control" required>
                <option value="">Pilih Jenis Kelamin</option>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
        </div>

        <div class="mb-3">
            <label><strong>Sub Kriteria Okupasi</strong></label>
            @foreach($okupasi as $item)
                <div class="form-check">
                    <input type="checkbox" name="okupasi[]" value="{{ $item->id }}" class="form-check-input">
                    <label class="form-check-label">{{ $item->nama_sub_kriteria }}</label>
                </div>
            @endforeach
        </div>

        <div class="mb-3">
            <label><strong>Sub Kriteria Wicara</strong></label>
            @foreach($wicara as $item)
                <div class="form-check">
                    <input type="checkbox" name="wicara[]" value="{{ $item->id }}" class="form-check-input">
                    <label class="form-check-label">{{ $item->nama_sub_kriteria }}</label>
                </div>
            @endforeach
        </div>

        <div class="mb-3">
            <label><strong>Sub Kriteria Fisioterapi</strong></label>
            @foreach($fisioterapi as $item)
                <div class="form-check">
                    <input type="checkbox" name="fisioterapi[]" value="{{ $item->id }}" class="form-check-input">
                    <label class="form-check-label">{{ $item->nama_sub_kriteria }}</label>
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary">Simpan & Hitung</button>
    </form>
</div>
@endsection
