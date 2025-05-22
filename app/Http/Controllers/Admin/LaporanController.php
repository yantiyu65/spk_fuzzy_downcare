<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\PerkembanganAnak;
use App\Http\Controllers\Controller;

class LaporanController extends Controller
{
    public function index()
    {
        $data = PerkembanganAnak::with('subkriterias')->latest()->get();
        return view('admin.laporan.index', compact('data'));
    }

    public function cetak()
    {
        $data = PerkembanganAnak::with('subkriterias')->latest()->get();
        $pdf = Pdf::loadView('admin.laporan.pdf', compact('data'));
        return $pdf->download('laporan-perkembangan-anak.pdf');
    }
}
