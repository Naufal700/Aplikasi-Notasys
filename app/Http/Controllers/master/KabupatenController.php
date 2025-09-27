<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\daerah\Kabupaten;
use App\Models\daerah\Provinsi;

class KabupatenController extends Controller
{
    // Tampilkan daftar kabupaten
    public function index()
    {
        $kabupaten = Kabupaten::with('provinsi')->orderBy('nama')->paginate(10);
        return view('kabupaten.index', compact('kabupaten'));
    }

    // Form tambah kabupaten
    public function create()
    {
        $provinsi = Provinsi::orderBy('nama')->get();
        return view('kabupaten.create', compact('provinsi'));
    }

    // Simpan kabupaten baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:kabupaten,nama',
            'provinsi_id' => 'required|exists:provinsi,id',
        ]);

        Kabupaten::create($request->all());

        return redirect()->route('kabupaten.index')->with('success', 'Kabupaten berhasil ditambahkan.');
    }

    // Form edit kabupaten
    public function edit(Kabupaten $kabupaten)
    {
        $provinsi = Provinsi::orderBy('nama')->get();
        return view('kabupaten.edit', compact('kabupaten', 'provinsi'));
    }

    // Update kabupaten
    public function update(Request $request, Kabupaten $kabupaten)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:kabupaten,nama,' . $kabupaten->id,
            'provinsi_id' => 'required|exists:provinsi,id',
        ]);

        $kabupaten->update($request->all());

        return redirect()->route('kabupaten.index')->with('success', 'Kabupaten berhasil diperbarui.');
    }

    // Hapus kabupaten
    public function destroy(Kabupaten $kabupaten)
    {
        $kabupaten->delete();
        return redirect()->route('kabupaten.index')->with('success', 'Kabupaten berhasil dihapus.');
    }

    // Ambil kabupaten berdasarkan provinsi (AJAX)
    public function getByProvinsi($provinsi_id)
    {
        $kabupaten = Kabupaten::where('provinsi_id', $provinsi_id)->orderBy('nama')->get();
        return response()->json($kabupaten);
    }
}
