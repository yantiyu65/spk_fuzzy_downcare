<?php

namespace App\Helpers;

class FungsiHelper
{
   public static function tentukanRentangUsia($tahun, $bulan)
{
    $usia = $tahun + ($bulan / 12); // konversi ke tahun desimal

    if ($usia >= 0 && $usia < 2) {
        return '0-2';
    } elseif ($usia >= 2 && $usia < 5) {
        return '2-5';
    } elseif ($usia >= 5 && $usia < 7) {
        return '5-7';
    } elseif ($usia >= 7 && $usia < 12) {
        return '7-12';
    } elseif ($usia >= 12 && $usia < 18) {
        return '12-18';
    } elseif ($usia >= 18 && $usia < 30) {
        return '18-30';
    } elseif ($usia >= 30) {
        return '30+';
    } else {
        return 'unknown'; // fallback aja, biar aman
    }
}

}
