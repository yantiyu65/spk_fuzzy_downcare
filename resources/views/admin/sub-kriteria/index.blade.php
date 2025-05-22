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
            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#SubKriteriaModal">
                <i class="bi bi-plus-circle me-1"></i> Tambah Sub-Kriteria
            </a>
        </div>
    </div>

    <!-- Modal -->
    
<div class="modal fade" id="SubKriteriaModal" tabindex="-1" aria-labelledby="kriteriaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('admin.subkriteria.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="kriteriaModalLabel">Tambah Sub Kriteria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                </div>
                <div class="modal-body">
                    <label>Kriteria:</label>
                    <select name="kriteria_id" class="form-control" required>
                        @foreach($kriterias as $kriteria)
                            <option value="{{ $kriteria->id }}">{{ $kriteria->nama_kriteria }}</option>
                        @endforeach
                    </select>

                    <label>Nama Sub Kriteria:</label>
                    <input type="text" name="nama_sub_kriteria" class="form-control" required>

                    <label>Nilai:</label>
                    <input type="number"  name="nilai" min="1" max="5" value="1" class="form-control" required>
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
                var modalTambah = new bootstrap.Modal(document.getElementById('SubKriteriaModal'));
                modalTambah.show();
            });
        </script>
    @endif

    {{-- Alert sukses --}}
    @if(session('success'))
        <div class="alert alert-success mt-2">{{ session('success') }}</div>
    @endif

    <!-- Tabel User -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Nama Kriteria</th>
                    <th>Sub Kriteria</th>
                    <th>Nilai</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($subkriterias as $index => $sub)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{$sub->kriteria->nama_kriteria ?? '-'  }}</td>
                        <td>{{$sub->nama_sub_kriteria  }}</td>
                        <td>{{$sub->nilai  }}</td>
                      
                
                        <td>
                            <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $sub->id }}">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                              {{-- modul edit --}}
                              <div class="modal fade" id="editModal{{ $sub->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $sub->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form method="POST" action="{{ route('admin.subkriteria.update', $sub->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel{{ $sub->id }}">Edit Sub Kriteria</h5>
                                                <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <label>Kriteria:</label>
                                                <select name="kriteria_id" class="form-control" required>
                                                    @foreach($kriterias as $k)
                                                        <option value="{{ $k->id }}" {{ $sub->kriteria_id == $k->id ? 'selected' : '' }}>
                                                            {{ $k->nama_kriteria }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                
                
                                                <label>Nama Kriteria:</label>
                                                <input type="text" name="nama_sub_kriteria" value="{{ $sub->nama_sub_kriteria }}" class="form-control" required>
                
                                                <label>nilai:</label>
                                                <input type="number" name="nilai"  value="{{ $sub->nilai }}" class="form-control" required>
                
                                              
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Update</button>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <form action="{{ route('admin.subkriteria.destroy', $sub->id) }}" method="POST" class="d-inline">
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