<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use Illuminate\Http\Request;
use App\Models\PerkembanganAnak;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
    $totalUser = User::count();
    $totalPerkembangan = PerkembanganAnak::count();
    $totalKriteria = Kriteria::count();
    $totalSubKriteria = SubKriteria::count();


    return view('admin.dashboard', compact(
        'totalUser',
        'totalPerkembangan',
        'totalKriteria',
        'totalSubKriteria',
       
    ));
    }
}
