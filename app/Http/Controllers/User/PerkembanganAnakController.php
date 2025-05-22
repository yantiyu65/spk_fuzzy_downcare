<?php

namespace App\Http\Controllers\User;

use App\Models\SubKriteria;
use Illuminate\Http\Request;
use App\Models\PerkembanganAnak;
use App\Helpers\FuzzyLogicHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PerkembanganAnakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = PerkembanganAnak::where('user_id', Auth::id())->latest()->get();
        return view('user.perkembangan-anak.index', compact('data'));
    
    }

    public function create(Request $request)
    {
    // Jika tidak ada ?new=true, maka redirect ke hasil terakhir
    if (!$request->has('new')) {
        $last = PerkembanganAnak::where('user_id', auth()->id())->latest()->first();

        if ($last) {
            return redirect()->route('user.perkembangan-anak.show', $last->id);
        }
    }

    return view('user.perkembangan-anak.create', [
        'okupasi' => SubKriteria::where('kriteria_id', 1)->get(),
        'wicara' => SubKriteria::where('kriteria_id', 2)->get(),
        'fisioterapi' => SubKriteria::where('kriteria_id', 3)->get()
    ]);
    

    }
    
    public function store(Request $request)
{
    $request->validate([
        'nama_anak' => 'required|string|max:255',
        'usia' => 'required|integer',
        'jenis_kelamin' => 'required|string',
        'okupasi' => 'required|array',
        'wicara' => 'required|array',
        'fisioterapi' => 'required|array',
        'tanggal' => now()->toDateString(),
    ]);

    $nilaiOkupasi = max(array_map(fn($id) => SubKriteria::find($id)?->nilai ?? 0, $request->okupasi));
    $nilaiWicara = max(array_map(fn($id) => SubKriteria::find($id)?->nilai ?? 0, $request->wicara));
    $nilaiFisioterapi = max(array_map(fn($id) => SubKriteria::find($id)?->nilai ?? 0, $request->fisioterapi));

    $perkembangan = PerkembanganAnak::create([
        'nama_anak' => $request->nama_anak,
        'usia' => $request->usia,
        'jenis_kelamin' => $request->jenis_kelamin,
        'user_id' => auth()->id(),
        'tanggal' => now()->toDateString(),
        'okupasi' => $nilaiOkupasi,
        'wicara' => $nilaiWicara,
        'fisioterapi' => $nilaiFisioterapi,
    ]);

    // CEK APAKAH TERISI
    if (!$perkembangan) {
        return back()->with('error', 'Gagal menyimpan data.');
    }

    $result = FuzzyLogicHelper::hitung($nilaiOkupasi, $nilaiWicara, $nilaiFisioterapi);

    $perkembangan->update([
        'nilai_z' => $result['z'],
        'kategori' => $result['diagnosis'],
        'rekomendasi' => $result['rekomendasi'],
    ]);

    return redirect()->route('user.perkembangan-anak.show', $perkembangan->id)
                     ->with('success', 'Data berhasil disimpan!');
    // return redirect()->route('user.perkembangan-anak.show', $perkembangan->id)
    //                  ->with('success', 'Data berhasil disimpan!');
}

    

    public function show($id)
    {
        $data = PerkembanganAnak::with('subkriterias')->findOrFail($id);
        return view('user.perkembangan-anak.hasil', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
