@extends('admin.layouts.admin') 
@section('title', 'Kriteria')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <a href="{{ route('admin.kriteria') }}" class="btn btn-outline-primary me-2">Kriteria</a>
            <a href="{{ route('admin.subkriteria') }}" class="btn btn-outline-primary">Sub Kriteria</a>
        </div>
        <div class="d-flex justify-content-end mb-3 mt-3">
            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kriteriaModal">
                <i class="bi bi-plus-circle me-1"></i> Tambah Kriteria
            </a>
        </div>
    </div>

    <!-- Modal -->
    <!-- Modal -->
    <div class="modal fade" id="kriteriaModal" tabindex="-1" aria-labelledby="kriteriaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('admin.kriteria.store') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="kriteriaModalLabel">Tambah Kriteria</h5>
                        <button type="button" data-bs-dismiss="modal" aria-label="Close">×</button>
                    </div>
                    <div class="modal-body">
                        <label>Kode:</label>
                        {{-- <input type="text" name="kode" class="form-control" required> --}}

                        <label>Nama Kriteria:</label>
                        <input type="text" name="nama_kriteria" class="form-control" required>

                        <label>Bobot:</label>
                        <input type="number" name="bobot" step="0.1" min="0.1" max="0.4" value="0.1" class="form-control" required>


                        <label>Tipe:</label>
                        <select name="tipe" class="form-control" required>
                            <option value="benefit">Benefit</option>
                            <option value="cost">Cost</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- Modal Otomatis Muncul Jika Ada Error --}}
    @if ($errors->any())
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var modalTambah = new bootstrap.Modal(document.getElementById('kriteriaModal'));
                modalTambah.show();
            });
        </script>
    @endif

    {{-- Alert sukses --}}
    @if(session('success'))
        <div class="alert alert-success mt-2">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger mt-2">{{ session('error') }}</div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var modalTambah = new bootstrap.Modal(document.getElementById('kriteriaModal'));
            modalTambah.show();
        });
    </script>
    @endif


    <!-- Tabel User -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Kode</th>
                    <th>Nama Kriteria</th>
                    <th>Bobot</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kriterias as $index => $kriteria)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{$kriteria->kode }}</td>
                        <td>{{$kriteria->nama_kriteria }}</td>
                        <td>{{$kriteria->bobot  }}</td>
                        <td>{{$kriteria->tipe  }}</td>
                
                        <td>
                            <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $kriteria->id }}">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                              {{-- modul edit --}}
                              <div class="modal fade" id="editModal{{ $kriteria->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $kriteria->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form method="POST" action="{{ route('admin.kriteria.update', $kriteria->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel{{ $kriteria->id }}">Edit Kriteria</h5>
                                                <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <label>Kode:</label>
                                                <input type="text" name="kode" value="{{ $kriteria->kode }}" class="form-control" required>
                
                                                <label>Nama Kriteria:</label>
                                                <input type="text" name="nama_kriteria" value="{{ $kriteria->nama_kriteria }}" class="form-control" required>
                
                                                <label>Bobot:</label>
                                                <input type="number" name="bobot" step="0.01" value="{{ $kriteria->bobot }}" class="form-control" required>
                
                                                <label>Tipe:</label>
                                                <select name="tipe" class="form-control" required>
                                                    <option value="benefit" {{ $kriteria->tipe == 'benefit' ? 'selected' : '' }}>Benefit</option>
                                                    <option value="cost" {{ $kriteria->tipe == 'cost' ? 'selected' : '' }}>Cost</option>
                                                </select>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Update</button>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <form action="{{ route('admin.kriteria.destroy', $kriteria->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus user ini?')">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                            
                            
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data Kriteria.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection