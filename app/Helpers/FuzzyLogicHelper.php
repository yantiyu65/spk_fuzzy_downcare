<?php

namespace App\Helpers;

use App\Models\SubKriteria;

class FuzzyLogicHelper
{
    public static function hitung($c1, $c2, $c3, $usiaKategori)
    {
        $fuzzyC1 = self::fuzzifikasi($c1);
        $fuzzyC2 = self::fuzzifikasi($c2);
        $fuzzyC3 = self::fuzzifikasi($c3);

        $mu_rendah  = min($fuzzyC1['rendah'], $fuzzyC2['rendah'], $fuzzyC3['rendah']);
        $mu_sedang  = max($fuzzyC1['sedang'], $fuzzyC2['sedang'], $fuzzyC3['sedang']);
        $mu_tinggi  = max($fuzzyC1['tinggi'], $fuzzyC2['tinggi'], $fuzzyC3['tinggi']);

        $z = round(((
            $mu_rendah * 1 +
            $mu_sedang * 3 +
            $mu_tinggi * 5
        ) / ($mu_rendah + $mu_sedang + $mu_tinggi ?: 1)), 2);

        if ($z <= 2) {
            $diagnosis = 'Stimulus Perkembangan Anak: Rendah';
            $kategori = 'rendah';
        } elseif ($z <= 4) {
            $diagnosis = 'Stimulus Perkembangan Anak: Sedang';
            $kategori = 'sedang';
        } else {
            $diagnosis = 'Stimulus Perkembangan Anak: Tinggi';
            $kategori = 'tinggi';
        }

        $rekomendasiMap = [
            'rendah' => [
                '0-2' => 'Kontak mata, panggilan nama, dan latihan tengkurap.',
                '2-5' => 'Latih anak menunjuk, menyebut benda, dan jalan dengan bantuan.',
                '5-7' => 'Kenalkan benda sekitar, rutinitas konsisten, aktivitas motorik dasar.',
                'default' => 'Stimulasi dasar dan latihan kemandirian secara bertahap.'
            ],
            'sedang' => [
                '0-2' => 'Gunakan mainan bunyi, tepuk tangan, dan gerakan sederhana.',
                '2-5' => 'Bernyanyi, membaca gambar, menyebut nama keluarga.',
                '5-7' => 'Susun balok, perintah sederhana, gerakan meniru.',
                'default' => 'Permainan edukatif dan narasi pendek yang menyenangkan.'
            ],
            'tinggi' => [
                '0-2' => 'Respons nama, tiru suara, dan tunjuk gambar.',
                '2-5' => 'Percakapan sederhana, menyanyi, dan bermain bersama.',
                '5-7' => 'Kegiatan mandiri: menyusun barang, bercerita pendek.',
                'default' => 'Aktivitas sosial, menyusun cerita, dan latihan bertahap mandiri.'
            ]
        ];

        $rekomendasi = $rekomendasiMap[$kategori][$usiaKategori] ?? $rekomendasiMap[$kategori]['default'];

        return [
            'z' => $z,
            'diagnosis' => $diagnosis,
            'rekomendasi' => $rekomendasi
        ];
    }

    public static function hitungLengkap($c1, $c2, $c3, $usiaKategori)
    {
        $fuzzyC1 = self::fuzzifikasi($c1);
        $fuzzyC2 = self::fuzzifikasi($c2);
        $fuzzyC3 = self::fuzzifikasi($c3);

        $fuzzyfikasi = [
            ['kriteria' => 'C1', 'nilai' => $c1, 'label' => 'Rendah', 'derajat' => $fuzzyC1['rendah']],
            ['kriteria' => 'C1', 'nilai' => $c1, 'label' => 'Sedang', 'derajat' => $fuzzyC1['sedang']],
            ['kriteria' => 'C1', 'nilai' => $c1, 'label' => 'Tinggi', 'derajat' => $fuzzyC1['tinggi']],
            ['kriteria' => 'C2', 'nilai' => $c2, 'label' => 'Rendah', 'derajat' => $fuzzyC2['rendah']],
            ['kriteria' => 'C2', 'nilai' => $c2, 'label' => 'Sedang', 'derajat' => $fuzzyC2['sedang']],
            ['kriteria' => 'C2', 'nilai' => $c2, 'label' => 'Tinggi', 'derajat' => $fuzzyC2['tinggi']],
            ['kriteria' => 'C3', 'nilai' => $c3, 'label' => 'Rendah', 'derajat' => $fuzzyC3['rendah']],
            ['kriteria' => 'C3', 'nilai' => $c3, 'label' => 'Sedang', 'derajat' => $fuzzyC3['sedang']],
            ['kriteria' => 'C3', 'nilai' => $c3, 'label' => 'Tinggi', 'derajat' => $fuzzyC3['tinggi']],
        ];

        $inferensi = [
            ['if' => 'rendah AND rendah AND rendah', 'then' => 'Rendah', 'alpha' => min($fuzzyC1['rendah'], $fuzzyC2['rendah'], $fuzzyC3['rendah']), 'z' => 1],
            ['if' => 'sedang AND sedang AND sedang', 'then' => 'Sedang', 'alpha' => min($fuzzyC1['sedang'], $fuzzyC2['sedang'], $fuzzyC3['sedang']), 'z' => 3],
            ['if' => 'tinggi AND tinggi AND tinggi', 'then' => 'Tinggi', 'alpha' => min($fuzzyC1['tinggi'], $fuzzyC2['tinggi'], $fuzzyC3['tinggi']), 'z' => 5],
        ];

        $sumAlphaZ = 0;
        $sumAlpha = 0;
        foreach ($inferensi as $inf) {
            $sumAlphaZ += $inf['alpha'] * $inf['z'];
            $sumAlpha += $inf['alpha'];
        }

        $z = round(($sumAlphaZ / ($sumAlpha ?: 1)), 2);

        if ($z <= 2) {
            $kategori = 'Stimulus Perkembangan Anak: Rendah';
            $kategoriKey = 'rendah';
        } elseif ($z <= 4) {
            $kategori = 'Stimulus Perkembangan Anak: Sedang';
            $kategoriKey = 'sedang';
        } else {
            $kategori = 'Stimulus Perkembangan Anak: Tinggi';
            $kategoriKey = 'tinggi';
        }

        $rekomendasiMap = [/* sama seperti di atas, bisa direuse atau extract ke fungsi lain */];
        $rekomendasi = $rekomendasiMap[$kategoriKey][$usiaKategori] ?? $rekomendasiMap[$kategoriKey]['default'];

        return [
            'fuzzyfikasi' => $fuzzyfikasi,
            'inferensi' => $inferensi,
            'sumAlphaZ' => $sumAlphaZ,
            'sumAlpha' => $sumAlpha,
            'z_akhir' => $z,
            'kategori' => $kategori,
            'rekomendasi' => $rekomendasi,
        ];
    }

    private static function fuzzifikasi($x)
    {
        if ($x <= 1) {
            $rendah = 1;
        } elseif ($x <= 3) {
            $rendah = (3 - $x) / 2;
        } else {
            $rendah = 0;
        }

        if ($x <= 2 || $x >= 5) {
            $sedang = 0;
        } elseif ($x <= 4) {
            $sedang = ($x - 2) / 2;
        } else {
            $sedang = (5 - $x);
        }

        if ($x <= 4) {
            $tinggi = 0;
        } elseif ($x <= 5) {
            $tinggi = ($x - 4);
        } else {
            $tinggi = 1;
        }

        return [
            'rendah' => round($rendah, 2),
            'sedang' => round($sedang, 2),
            'tinggi' => round($tinggi, 2)
        ];
    }

    public static function getNamaSubkriteria($kriteriaId, $nilai)
    {
        return SubKriteria::where('kriteria_id', $kriteriaId)
            ->where('nilai', $nilai)
            ->pluck('nama_sub_kriteria')
            ->toArray();
    }
    public static function ambilNilaiTertinggiDariSubkriteria(array $ids, string $kategoriUsiaAnak)
{
    $semua = SubKriteria::whereIn('id', $ids)->get();

    $urutanUsia = [
        '0-2', '2-5', '5-7', '7-12', '12-18', '18-30', '30+'
    ];

    // Ambil indeks dari rentang usia anak
    $indexAnak = array_search($kategoriUsiaAnak, $urutanUsia);

    if ($indexAnak === false) return 0;

    // Filter subkriteria yang sesuai atau lebih rendah dari usia anak
    $filtered = $semua->filter(function ($item) use ($urutanUsia, $indexAnak) {
        $indexItem = array_search($item->rentang_usia, $urutanUsia);
        return $indexItem !== false && $indexItem <= $indexAnak;
    });

    // Ambil nilai tertinggi dari yang sesuai
    return $filtered->max('nilai') ?? 0;
}

}
