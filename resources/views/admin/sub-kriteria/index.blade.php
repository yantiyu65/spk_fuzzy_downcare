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
                        
                        <label>Rentang Usia:</label>
                        <select name="rentang_usia" class="form-control">
                            <option value="24 - 60">2 - 5 tahun</option>
                            <option value="60 - 84">5 - 7 tahun</option>
                            <option value="84 - 144">7 - 12 tahun</option>
                            <option value="144 - 216">12 - 18 tahun</option>
                            <option value="216 - 360">18 - 30 tahun</option>
                            <option value="360 - 999">30 tahun ke atas</option>
                        </select>
                        
                        <label>Tahapan:</label>
                        <input type="text" name="tahapan" class="form-control"  required>
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
                    <th>Rentang Usia</th>
                    <th>Tahapan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($subkriterias as $index => $sub)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $sub->kriteria->nama_kriteria ?? '-' }}</td>
                        <td>{{ $sub->nama_sub_kriteria }}</td>
                        <td>{{ $sub->nilai }}</td>
                        <td>{{ $sub->rentang_usia }}</td>
                        <td>{{ $sub->tahapan }}</td>
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
                                                <label>Nilai:</label>
                                                <input type="number" name="nilai" min="1" max="5" value="{{ $sub->nilai }}" class="form-control" required>
                                                <label>Rentang Usia:</label>
                                                <select name="rentang_usia" class="form-control" required>
                                                    <option value="24 - 60" {{ $sub->rentang_usia == '24 - 60' ? 'selected' : '' }}>2 - 5 tahun</option>
                                                    <option value="60 - 84" {{ $sub->rentang_usia == '60 - 84' ? 'selected' : '' }}>5 - 7 tahun</option>
                                                    <option value="84 - 144" {{ $sub->rentang_usia == '84 - 144' ? 'selected' : '' }}>7 - 12 tahun</option>
                                                    <option value="144 - 216" {{ $sub->rentang_usia == '144 - 216' ? 'selected' : '' }}>12 - 18 tahun</option>
                                                    <option value="216 - 360" {{ $sub->rentang_usia == '216 - 360' ? 'selected' : '' }}>18 - 30 tahun</option>
                                                    <option value="360 - 999" {{ $sub->rentang_usia == '360 - 999' ? 'selected' : '' }}>30 tahun ke atas</option>
                                                </select>
                                                <label>Tahapan:</label>
                                                <input type="text" name="tahapan" value="{{ $sub->tahapan }}" class="form-control" required>
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
                        <td colspan="7" class="text-center">Tidak ada data Kriteria.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-3">
        {{ $subkriterias->links('pagination::bootstrap-5') }}
    </div>
</div>

@endsection
