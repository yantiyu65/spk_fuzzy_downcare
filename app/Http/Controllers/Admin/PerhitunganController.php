<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\PerkembanganAnak;
use App\Models\SubKriteria;
use App\Helpers\FuzzyLogicHelper;
use App\Http\Controllers\Controller;

class PerhitunganController extends Controller
{
    public function index(Request $request)
    {
        $query = PerkembanganAnak::query();

        // Filter berdasarkan anak jika ada
        if ($request->filled('anak_id')) {
            $query->where('id', $request->anak_id);
        }

        $dataAnak = $query->orderBy('created_at', 'desc')->get();
        $semuaAnak = PerkembanganAnak::orderBy('nama_anak')->get();

        $hasilPerhitungan = [];

        foreach ($dataAnak as $anak) {
            $hasil = FuzzyLogicHelper::hitungLengkap($anak->okupasi, $anak->wicara, $anak->fisioterapi);

            foreach ($hasil['fuzzyfikasi'] as &$row) {
                if ($row['kriteria'] === 'C1') {
                    $subList = FuzzyLogicHelper::getNamaSubkriteria(1, $anak->okupasi);
                } elseif ($row['kriteria'] === 'C2') {
                    $subList = FuzzyLogicHelper::getNamaSubkriteria(2, $anak->wicara);
                } elseif ($row['kriteria'] === 'C3') {
                    $subList = FuzzyLogicHelper::getNamaSubkriteria(3, $anak->fisioterapi);
                } else {
                    $subList = [];
                }

                $row['nama_sub_kriteria'] = $subList;
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
