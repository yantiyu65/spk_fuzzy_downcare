@extends('user.layouts.user')
@section('content')
<div class="container mt-4 p-4 bg-light rounded shadow">
    <h4 class="mb-4 text-primary text-center fw-bold">
        <i class="bi bi-journal-check"></i> Form Cek Perkembangan Anak
    </h4>

    {{-- Step Progress Bar --}}
    <div class="mb-4 text-center">
        <h6 id="stepIndicator" class="fw-bold">Langkah 1 dari 4</h6>
        <div class="progress" style="height: 8px;">
            <div class="progress-bar bg-primary" id="progressBar" role="progressbar" style="width: 25%"></div>
        </div>
    </div>

    {{-- Catatan --}}
    <div class="alert alert-info">
        <strong>Catatan:</strong> Jawablah sesuai <strong>kemampuan anak saat ini</strong> tanpa memaksakan harus bisa semua.
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('user.perkembangan-anak.store') }}" method="POST" id="formPerkembangan">
        @csrf

        {{-- Step 1: Data Anak --}}
        <div class="step" id="step1">
            <h5 class="fw-bold text-primary">1. Data Anak</h5>
            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Anak</label>
                <input type="text" name="nama_anak" class="form-control" required value="{{ old('nama_anak', $lastData->nama_anak ?? '') }}">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Usia Anak</label>
                <div class="row">
                    <div class="col-6">
                        <input type="number" name="usia_tahun" class="form-control" placeholder="Tahun" min="0" required value="{{ old('usia_tahun', $lastData->usia_tahun ?? '') }}">
                    </div>
                    <div class="col-6">
                        <input type="number" name="usia_bulan" class="form-control" placeholder="Bulan" min="0" max="11" required value="{{ old('usia_bulan', $lastData->usia_bulan ?? '') }}">
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-select" required>
                    <option value="">-- Pilih Jenis Kelamin --</option>
                    <option value="Laki-laki" {{ old('jenis_kelamin', $lastData->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ old('jenis_kelamin', $lastData->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-primary" onclick="nextStep(1)">Lanjut</button>
            </div>
        </div>

        {{-- Step 2: Wicara --}}
        <div class="step d-none" id="step2">
            <h5 class="fw-bold text-primary">2. Subkriteria Wicara</h5>
            <div class="mb-3 p-3 bg-white rounded shadow-sm border">
                @foreach ($wicara as $item)
                 
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="wicara[]" value="{{ $item->id }}" id="wicara{{ $item->id }}">
                        <label class="form-check-label" for="wicara{{ $item->id }}" title="Contoh: {{ $item->contoh_aktivitas ?? '-' }}">
                            {{ $item->nama_sub_kriteria }}
                        </label>
                    </div>
                
                @endforeach
            </div>
            <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" onclick="prevStep(2)">Kembali</button>
                <button type="button" class="btn btn-primary" onclick="nextStep(2)">Lanjut</button>
            </div>
        </div>

        {{-- Step 3: Okupasi --}}
        <div class="step d-none" id="step3">
            <h5 class="fw-bold text-primary">3. Subkriteria Okupasi</h5>
            <div class="mb-3 p-3 bg-white rounded shadow-sm border">
                
                @foreach ($okupasi as $item)
                 
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="okupasi[]" value="{{ $item->id }}" id="okupasi{{ $item->id }}">
                        <label class="form-check-label" for="okupasi{{ $item->id }}" title="Contoh: {{ $item->contoh_aktivitas ?? '-' }}">
                            {{ $item->nama_sub_kriteria }}
                        </label>
                    </div>
                    
                @endforeach
            </div>
            <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" onclick="prevStep(3)">Kembali</button>
                <button type="button" class="btn btn-primary" onclick="nextStep(3)">Lanjut</button>
            </div>
        </div>

        {{-- Step 4: Fisioterapi --}}
        <div class="step d-none" id="step4">
            <h5 class="fw-bold text-primary">4. Subkriteria Fisioterapi</h5>
            <div class="mb-3 p-3 bg-white rounded shadow-sm border">
                @foreach ($fisioterapi as $item)
                 
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="fisioterapi[]" value="{{ $item->id }}" id="fisioterapi{{ $item->id }}">
                        <label class="form-check-label" for="fisioterapi{{ $item->id }}" title="Contoh: {{ $item->contoh_aktivitas ?? '-' }}">
                            {{ $item->nama_sub_kriteria }}
                        </label>
                    </div>
                 
                @endforeach
            </div>
            <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" onclick="prevStep(4)">Kembali</button>
                <button type="submit" class="btn btn-success fw-bold">
                    <i class="bi bi-save"></i> Simpan & Hitung
                </button>
            </div>
        </div>
    </form>
</div>

{{-- Step Script --}}
<script>
    function showStep(step) {
        const totalSteps = 4;
        for (let i = 1; i <= totalSteps; i++) {
            const el = document.getElementById('step' + i);
            el.classList.toggle('d-none', i !== step);
        }

        // Update progress bar dan indikator
        document.getElementById('stepIndicator').innerText = `Langkah ${step} dari ${totalSteps}`;
        document.getElementById('progressBar').style.width = `${(step / totalSteps) * 100}%`;
    }

    function nextStep(current) {
        if (current < 4) showStep(current + 1);
    }

    function prevStep(current) {
        if (current > 1) showStep(current - 1);
    }

    // AJAX: Ambil subkriteria sesuai usia anak
    function fetchSubkriteriaByUsia() {
        const tahun = document.querySelector('input[name="usia_tahun"]').value || 0;
        const bulan = document.querySelector('input[name="usia_bulan"]').value || 0;
        const token = document.querySelector('input[name="_token"]').value;

        fetch(`{{ route('get.subkriteria.usia') }}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
            },
            body: JSON.stringify({ tahun, bulan })
        })
        .then(response => response.json())
        .then(data => {
            updateSubkriteriaList('wicara', data.wicara);
            updateSubkriteriaList('okupasi', data.okupasi);
            updateSubkriteriaList('fisioterapi', data.fisioterapi);
        });
    }

    function updateSubkriteriaList(kategori, items) {
        const stepId = kategori === 'wicara' ? 2 : kategori === 'okupasi' ? 3 : 4;
        const container = document.querySelector(`#step${stepId} .mb-3`);
        container.innerHTML = '';

        if (items.length === 0) {
            container.innerHTML = `<p class="text-danger">Tidak ada subkriteria untuk usia ini.</p>`;
            return;
        }

        items.forEach(item => {
            container.innerHTML += `
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="${kategori}[]" value="${item.id}" id="${kategori}${item.id}">
                    <label class="form-check-label" for="${kategori}${item.id}" title="Contoh: ${item.contoh_aktivitas ?? '-'}">
                        ${item.nama_sub_kriteria}
                    </label>
                </div>
            `;
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        showStep(1);
        fetchSubkriteriaByUsia();
    });

    document.querySelector('input[name="usia_tahun"]').addEventListener('change', fetchSubkriteriaByUsia);
    document.querySelector('input[name="usia_bulan"]').addEventListener('change', fetchSubkriteriaByUsia);
</script>

@endsection
