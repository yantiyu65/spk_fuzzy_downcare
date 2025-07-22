<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use App\Models\PerkembanganAnak;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUser = User::count();
        $totalPerkembangan = PerkembanganAnak::count();
        $totalKriteria = Kriteria::count();
        $totalSubKriteria = SubKriteria::count();

        // Ambil label chart langsung dari usia_tahun (BUKAN usia range)
        $usiaCounts = DB::table('perkembangan_anaks')
            ->select('usia_tahun', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('usia_tahun')
            ->orderBy('usia_tahun')
            ->pluck('jumlah', 'usia_tahun')
            ->toArray();

        $tahapanCounts = DB::table('perkembangan_anaks') 
            ->select('kategori', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('kategori')
            ->orderBy('kategori')
            ->pluck('jumlah', 'kategori')
            ->toArray();

        return view('admin.dashboard', compact(
            'totalUser',
            'totalPerkembangan',
            'totalKriteria',
            'totalSubKriteria',
            'usiaCounts',
            'tahapanCounts'
        ));
    }
}
