<?php

namespace App\Helpers;

use App\Models\SubKriteria;

class FuzzyLogicHelper
{
    public static function hitung($c1, $c2, $c3)
    {
        // --- Fuzzifikasi ---

        $fuzzyC1 = self::fuzzifikasi($c1);
        $fuzzyC2 = self::fuzzifikasi($c2);
        $fuzzyC3 = self::fuzzifikasi($c3);

        // --- Inferensi ---

        $mu_rendah  = min($fuzzyC1['rendah'], $fuzzyC2['rendah'], $fuzzyC3['rendah']);
        $mu_sedang  = max($fuzzyC1['sedang'], $fuzzyC2['sedang'], $fuzzyC3['sedang']);
        $mu_berat   = max($fuzzyC1['berat'], $fuzzyC2['berat'], $fuzzyC3['berat']);

        // --- Defuzzifikasi (Metode COG) ---
        $z = round((
            ($mu_rendah * 1) +
            ($mu_sedang * 3) +
            ($mu_berat * 5)
        ) / (
            $mu_rendah + $mu_sedang + $mu_berat ?: 1
        ), 2);

        // --- Penentuan Diagnosis & Rekomendasi ---
        if ($z <= 2) {
            $diagnosis = 'Tunagrahita Ringan';
            $rekomendasi = 'Latihan motorik halus dan kasar, pengenalan angka dan huruf, terapi wicara dasar.';
        } elseif ($z <= 4) {
            $diagnosis = 'Tunagrahita Sedang';
            $rekomendasi = 'Latihan koordinasi dan kemandirian, komunikasi verbal & non-verbal, terapi okupasi menengah.';
        } else {
            $diagnosis = 'Tunagrahita Berat';
            $rekomendasi = 'Terapi okupasi intensif, terapi wicara lanjutan, latihan aktivitas sehari-hari.';
        }

        return [
            'z' => $z,
            'diagnosis' => $diagnosis,
            'rekomendasi' => $rekomendasi
        ];
    }

    private static function fuzzifikasi($x)
    {
        // Rendah
        if ($x <= 1) {
            $rendah = 1;
        } elseif ($x <= 3) {
            $rendah = (3 - $x) / 2;
        } else {
            $rendah = 0;
        }

        // Sedang
        if ($x <= 2 || $x >= 5) {
            $sedang = 0;
        } elseif ($x <= 4) {
            $sedang = ($x - 2) / 2;
        } else {
            $sedang = (5 - $x) / 2;
        }

        // Berat
        if ($x <= 4) {
            $berat = 0;
        } elseif ($x <= 5) {
            $berat = ($x - 4) / 1;
        } else {
            $berat = 1;
        }

        return [
            'rendah' => round($rendah, 2),
            'sedang' => round($sedang, 2),
            'berat' => round($berat, 2)
        ];
    }

    public static function hitungLengkap($c1, $c2, $c3)
    {
    // Fuzzifikasi
    $fuzzyC1 = self::fuzzifikasi($c1);
    $fuzzyC2 = self::fuzzifikasi($c2);
    $fuzzyC3 = self::fuzzifikasi($c3);

    $fuzzyfikasi = [
        ['kriteria' => 'C1', 'nama_sub_kriteria' => $c1, 'label' => 'Rendah', 'derajat' => $fuzzyC1['rendah']],
        ['kriteria' => 'C1', 'nama_sub_kriteria' => $c1, 'label' => 'Sedang', 'derajat' => $fuzzyC1['sedang']],
        ['kriteria' => 'C1', 'nama_sub_kriteria' => $c1, 'label' => 'Berat', 'derajat' => $fuzzyC1['berat']],

        ['kriteria' => 'C2', 'nama_sub_kriteria' => $c2, 'label' => 'Rendah', 'derajat' => $fuzzyC2['rendah']],
        ['kriteria' => 'C2', 'nama_sub_kriteria' => $c2, 'label' => 'Sedang', 'derajat' => $fuzzyC2['sedang']],
        ['kriteria' => 'C2', 'nama_sub_kriteria' => $c2, 'label' => 'Berat', 'derajat' => $fuzzyC2['berat']],

        ['kriteria' => 'C3', 'nama_sub_kriteria' => $c3, 'label' => 'Rendah', 'derajat' => $fuzzyC3['rendah']],
        ['kriteria' => 'C3', 'nama_sub_kriteria' => $c3, 'label' => 'Sedang', 'derajat' => $fuzzyC3['sedang']],
        ['kriteria' => 'C3', 'nama_sub_kriteria' => $c3, 'label' => 'Berat', 'derajat' => $fuzzyC3['berat']],
    ];

    // Inferensi sederhana (3 rule contoh)
    $inferensi = [
        ['if' => 'rendah AND rendah AND rendah', 'then' => 'Ringan', 'alpha' => min($fuzzyC1['rendah'], $fuzzyC2['rendah'], $fuzzyC3['rendah']), 'z' => 1],
        ['if' => 'sedang AND sedang AND sedang', 'then' => 'Sedang', 'alpha' => min($fuzzyC1['sedang'], $fuzzyC2['sedang'], $fuzzyC3['sedang']), 'z' => 3],
        ['if' => 'berat AND berat AND berat', 'then' => 'Berat', 'alpha' => min($fuzzyC1['berat'], $fuzzyC2['berat'], $fuzzyC3['berat']), 'z' => 5],
    ];

    // Defuzzifikasi
    $sumAlphaZ = 0;
    $sumAlpha = 0;
    foreach ($inferensi as $inf) {
        $sumAlphaZ += $inf['alpha'] * $inf['z'];
        $sumAlpha += $inf['alpha'];
    }

    $z = round(($sumAlphaZ / ($sumAlpha ?: 1)), 2);

    // Penentuan diagnosis
    if ($z <= 2) {
        $kategori = 'Tunagrahita Ringan';
        $rekomendasi = 'Latihan motorik halus dan kasar, pengenalan angka dan huruf, terapi wicara dasar.';
    } elseif ($z <= 4) {
        $kategori = 'Tunagrahita Sedang';
        $rekomendasi = 'Latihan koordinasi dan kemandirian, komunikasi verbal & non-verbal, terapi okupasi menengah.';
    } else {
        $kategori = 'Tunagrahita Berat';
        $rekomendasi = 'Terapi okupasi intensif, terapi wicara lanjutan, latihan aktivitas sehari-hari.';
    }

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

public static function getNamaSubkriteria($kriteriaId, $nilai)
{
    return SubKriteria::where('kriteria_id', $kriteriaId)
                      ->where('nilai', $nilai)
                      ->value('nama_sub_kriteria') ?? 'Tidak Ditemukan';
}

}
