<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\PerkembanganAnak;
use App\Helpers\FuzzyLogicHelper;
use App\Http\Controllers\Controller;

class PerhitunganController extends Controller
{
  
    public function index(Request $request)
{
    $query = PerkembanganAnak::query();

    // Jika pakai filter anak
    if ($request->filled('anak_id')) {
        $query->where('id', $request->anak_id);
    }

    $dataAnak = $query->latest()->get();
    $semuaAnak = PerkembanganAnak::orderBy('nama_anak')->get();
    $hasilPerhitungan = [];

    foreach ($dataAnak as $anak) {
        $hasil = FuzzyLogicHelper::hitungLengkap($anak->okupasi, $anak->wicara, $anak->fisioterapi);

        foreach ($hasil['fuzzyfikasi'] as &$row) {
            if ($row['kriteria'] === 'C1') {
                $row['nama_sub_kriteria'] = FuzzyLogicHelper::getNamaSubkriteria(1, $anak->okupasi);
            } elseif ($row['kriteria'] === 'C2') {
                $row['nama_sub_kriteria'] = FuzzyLogicHelper::getNamaSubkriteria(2, $anak->wicara);
            } elseif ($row['kriteria'] === 'C3') {
                $row['nama_sub_kriteria'] = FuzzyLogicHelper::getNamaSubkriteria(3, $anak->fisioterapi);
            }
        }

        $hasilPerhitungan[] = [
            'anak' => $anak,
            'fuzzyfikasi' => $hasil['fuzzyfikasi'],
            'inferensi' => $hasil['inferensi'],
            'sumAlphaZ' => $hasil['sumAlphaZ'],
            'sumAlpha' => $hasil['sumAlpha'],
            'z_akhir' => $hasil['z_akhir'],
            'kategori' => $hasil['kategori'],
            'rekomendasi' => $hasil['rekomendasi'],
        ];
    }

    return view('admin.perhitungan.index', compact('hasilPerhitungan', 'semuaAnak'));
}

}