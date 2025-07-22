<?php

namespace App\Http\Controllers\User;

use App\Models\SubKriteria;
use Illuminate\Http\Request;
use App\Helpers\FungsiHelper;
use App\Models\PerkembanganAnak;
use App\Helpers\FuzzyLogicHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PerkembanganAnakController extends Controller
{
    public function index()
    {
          $data = PerkembanganAnak::where('user_id', Auth::id())
        ->orderBy('tanggal', 'asc')
        ->get();

         return view('user.perkembangan-anak.index', compact('data'));
    }

 public function create(Request $request)
{
    if (!$request->has('new')) {
        $last = PerkembanganAnak::where('user_id', auth()->id())->latest()->first();
        if ($last) {
            return redirect()->route('user.perkembangan-anak.show', $last->id);
        }
    }

    $lastData = PerkembanganAnak::where('user_id', auth()->id())->latest()->first();

    // Reset usia agar kosong saat input ulang
    if ($lastData) {
        $lastData->usia_tahun = null;
        $lastData->usia_bulan = null;
    }

    // Tentukan rentang usia berdasarkan data terakhir
    $rentang = '2-5'; // default

    if ($lastData && $lastData->usia_tahun !== null && $lastData->usia_bulan !== null) {
        $rentang = FungsiHelper::tentukanRentangUsia($lastData->usia_tahun, $lastData->usia_bulan);
    }

    // Ambil sub-kriteria sesuai rentang
    $okupasi = SubKriteria::where('kriteria_id', 1)->where('rentang_usia', $rentang)->get();
    $wicara = SubKriteria::where('kriteria_id', 2)->where('rentang_usia', $rentang)->get();
    $fisioterapi = SubKriteria::where('kriteria_id', 3)->where('rentang_usia', $rentang)->get();

    return view('user.perkembangan-anak.create', compact('okupasi', 'wicara', 'fisioterapi', 'lastData'));
}



    public function store(Request $request)
{
    $request->validate([
        'nama_anak' => 'required|string|max:255',
        'usia_tahun' => 'required|integer|min:0',
        'usia_bulan' => 'required|integer|min:0|max:11',
        'jenis_kelamin' => 'required|string',
        'okupasi' => 'required|array',
        'wicara' => 'required|array',
        'fisioterapi' => 'required|array',
    ],  [
        'usia_tahun.min' => 'Usia anak harus 0 tahun atau lebih.',
    ]);

    $usiaTahun = $request->usia_tahun;
    $usiaBulan = $request->usia_bulan;
    $usia = ($usiaTahun * 12) + $usiaBulan;

    $hasilTahapan = FungsiHelper::tentukanRentangUsia($usiaTahun, $usiaBulan);
    $kategori_usia = $hasilTahapan;

    // Ambil semua subkriteria sekali query
    $ids = array_merge($request->okupasi, $request->wicara, $request->fisioterapi);
    $subkriterias = SubKriteria::whereIn('id', $ids)->get()->keyBy('id');

    $nilaiOkupasi = FuzzyLogicHelper::ambilNilaiTertinggiDariSubkriteria($request->okupasi, $kategori_usia);
    $nilaiWicara = FuzzyLogicHelper::ambilNilaiTertinggiDariSubkriteria($request->wicara, $kategori_usia);
    $nilaiFisioterapi = FuzzyLogicHelper::ambilNilaiTertinggiDariSubkriteria($request->fisioterapi, $kategori_usia);


    $perkembangan = PerkembanganAnak::create([
        'nama_anak' => $request->nama_anak,
        'usia' => $usia,
        'usia_tahun' => $usiaTahun,
        'usia_bulan' => $usiaBulan,
        'jenis_kelamin' => $request->jenis_kelamin,
        'user_id' => auth()->id(),
        'okupasi' => $nilaiOkupasi,
        'wicara' => $nilaiWicara,
        'fisioterapi' => $nilaiFisioterapi,
        'kategori_usia' => $kategori_usia,
        'tanggal' => now(),
    ]);

    if (!$perkembangan) {
        return back()->with('error', 'Gagal menyimpan data.');
    }

    // Kirim juga kategori usia ke fuzzy
    $result = FuzzyLogicHelper::hitung($nilaiOkupasi, $nilaiWicara, $nilaiFisioterapi, $kategori_usia);

    $perkembangan->update([
        'nilai_z' => $result['z'],
        'kategori' => $result['diagnosis'],
        'rekomendasi' => $result['rekomendasi'],
    ]);

    return redirect()->route('user.perkembangan-anak.show', $perkembangan->id)
                     ->with('success', 'Data berhasil disimpan!');
}


   public function show($id)
{
    $data = PerkembanganAnak::with('subkriterias')->findOrFail($id);

    $usiaTahun = (int) ($data->usia_tahun ?? 0);
    $usiaBulan = (int) ($data->usia_bulan ?? 0);
    $tahapanUsia = FungsiHelper::tentukanRentangUsia($usiaTahun, $usiaBulan);

    // Hitung ulang diagnosis dengan kategori usia
    $result = FuzzyLogicHelper::hitung($data->okupasi, $data->wicara, $data->fisioterapi, $tahapanUsia);
    $kategoriBaru = $result['diagnosis'];
    $motivasi = $this->getMotivasiByKategori($kategoriBaru);

    $rentangNormal = '';
    if (str_contains($kategoriBaru, 'Tinggi')) {
        $rentangNormal = match ($tahapanUsia) {
            '0-2' => 'Kemampuan anak sesuai atau melampaui anak tipikal usia 0–2 tahun.',
            '2-5' => 'Kemampuan anak mendekati anak tipikal usia 2–5 tahun.',
            '5-7' => 'Setara dengan anak tipikal usia 5–7 tahun.',
            '7-12' => 'Sejajar dengan anak tipikal usia 7–12 tahun.',
            '12-18' => 'Kemampuan menyerupai usia remaja 12–18 tahun.',
            '18-30' => 'Perkembangan mendekati dewasa muda.',
            '30+' => 'Kemampuan mendekati usia dewasa.',
            default => 'Anak menunjukkan kemampuan di atas rata-rata usianya.',
        };
    }

    $data->kategori = $kategoriBaru; // Tampilkan diagnosis terbaru

    return view('user.perkembangan-anak.hasil', compact(
        'data',
        'tahapanUsia',
        'motivasi',
        'rentangNormal'
    ));
}

    private function getMotivasiByKategori($kategori)
{
    if (str_contains($kategori, 'Rendah')) {
        return 'Tidak apa-apa jika anak belum menunjukkan banyak kemampuan saat ini. Dengan pendampingan dan kasih sayang yang konsisten, anak bisa berkembang lebih baik.';
    } elseif (str_contains($kategori, 'Sedang')) {
        return 'Anak Anda sedang berada di tahap perkembangan yang baik. Terus berikan stimulasi dan semangat. Waktu dan perhatian orang tua sangat berarti.';
    } elseif (str_contains($kategori, 'Tinggi')) {
        return 'Luar biasa! Anak Anda menunjukkan perkembangan yang positif. Terus dukung dengan aktivitas menyenangkan yang merangsang tumbuh kembang.';
    }

    return '';
}


    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function getSubKriteriaByUsia(Request $request)
{
    $tahun = (int) $request->input('tahun');
    $bulan = (int) $request->input('bulan');

    $rentang = FungsiHelper::tentukanRentangUsia($tahun, $bulan);

    // Usia di bawah 2 tahun: hanya tampilkan subkriteria "0-2"
    if ($rentang === 'underage' || $rentang === '0-2') {
        $okupasi = SubKriteria::where('kriteria_id', 1)
                    ->where('rentang_usia', '0-2')->get();

        $wicara = SubKriteria::where('kriteria_id', 2)
                    ->where('rentang_usia', '0-2')->get();

        $fisioterapi = SubKriteria::where('kriteria_id', 3)
                    ->where('rentang_usia', '0-2')->get();

    } else {
        // Di atas 2 tahun: tampilkan SEMUA rentang usia
        $okupasi = SubKriteria::where('kriteria_id', 1)->get();
        $wicara = SubKriteria::where('kriteria_id', 2)->get();
        $fisioterapi = SubKriteria::where('kriteria_id', 3)->get();
    }

    return response()->json([
        'okupasi' => $okupasi,
        'wicara' => $wicara,
        'fisioterapi' => $fisioterapi,
    ]);
}


    public function destroy(string $id)
    {
        //
    }
}
