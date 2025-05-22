<?php

namespace App\Http\Controllers\Admin;

use App\Models\Kriteria;
use App\Models\SubKriteria;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubKriteriaController extends Controller
{
    public function index()
    {
        $subkriterias = SubKriteria::with('kriteria')->get(); // eager loading
        $kriterias = Kriteria::all(); // untuk form select
        return view('admin.sub-kriteria.index', compact('subkriterias', 'kriterias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kriteria_id' => 'required|exists:kriterias,id',
            'nama_sub_kriteria' => 'required|string|max:255',
            'nilai' => 'required|numeric'
        ]);

        SubKriteria::create($request->all());

        return redirect()->route('admin.subkriteria')->with('success', 'Sub Kriteria berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $sub = SubKriteria::findOrFail($id);

        $request->validate([
            'kriteria_id' => 'required|exists:kriterias,id',
            'nama_sub_kriteria' => 'required|string|max:255',
            'nilai' => 'required|numeric'
        ]);

        $sub->update($request->all());

        return redirect()->route('admin.subkriteria')->with('success', 'Sub Kriteria berhasil diupdate.');
    }

    public function destroy($id)
    {
        $sub = SubKriteria::findOrFail($id);
        $sub->delete();

        return redirect()->route('admin.subkriteria')->with('success', 'Sub Kriteria berhasil dihapus.');
    }
}
