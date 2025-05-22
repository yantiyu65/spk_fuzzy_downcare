<?php

namespace App\Http\Controllers\Admin;


use App\Models\Kriteria;
use App\Models\SubKriteria;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class KriteriaController extends Controller
{
     // Kriteria
     public function index()
     {
         $kriterias = Kriteria::all();
         return view('admin.kriteria.index', compact('kriterias'));
     }
 

 
    public function store(Request $request)
{
    $request->validate([
        'nama_kriteria' => 'required',
        'bobot' => 'required|numeric|min:0|max:1',
        'tipe' => 'required|in:cost,benefit',
    ]);

    // Hitung total bobot yang sudah ada
    $totalBobotSaatIni = Kriteria::sum('bobot');

    // Cek apakah penambahan bobot melebihi 1
    if ($totalBobotSaatIni + $request->bobot > 1) {
        return redirect()->back()->withInput()->with('error', 'Total bobot sudah mencapai batas maksimum (1). Kurangi bobot kriteria lainnya terlebih dahulu.');
    }

    // Ambil kode terakhir
    $lastKriteria = Kriteria::orderBy('id', 'desc')->first();
    $lastNumber = 1;

    if ($lastKriteria) {
        $lastNumber = (int)substr($lastKriteria->kode, 1) + 1;
    }

    $newKode = 'C' . str_pad($lastNumber, 2, '0', STR_PAD_LEFT); // C01, C02 dst

    Kriteria::create([
        'kode' => $newKode,
        'nama_kriteria' => $request->nama_kriteria,
        'bobot' => $request->bobot,
        'tipe' => $request->tipe,
    ]);

    return redirect()->route('admin.kriteria')->with('success', 'Kriteria berhasil ditambahkan');
    }

     public function update(Request $request, $id)
    {
    $request->validate([
        'nama_kriteria' => 'required',
        'bobot' => 'required|numeric|min:0|max:1',
        'tipe' => 'required|in:cost,benefit',
    ]);

    $kriteria = Kriteria::findOrFail($id);

    // Hitung total bobot selain yang sedang di-update
    $totalBobotLain = Kriteria::where('id', '!=', $id)->sum('bobot');

    // Cek jika bobot baru melebihi batas total
    if ($totalBobotLain + $request->bobot > 1) {
        return redirect()->back()->withInput()->with('error', 'Total bobot melebihi batas maksimum (1). Silakan sesuaikan kembali.');
    }

    $kriteria->update([
        'nama_kriteria' => $request->nama_kriteria,
        'bobot' => $request->bobot,
        'tipe' => $request->tipe,
    ]);

    return redirect()->route('admin.kriteria')->with('success', 'Kriteria berhasil diupdate.');
    }


    public function destroy($id)
    {
        $user = Kriteria::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.kriteria')->with('success', 'Kriteria berhasil dihapus.');
    }
     // Sub Kriteria
     public function subkriteria()
     {
         $subkriterias = SubKriteria::all(); // pastikan modelnya ada
         return view('admin.sub-kriteria.index', compact('subkriterias'));
     }
    
}
