<?php

namespace App\Http\Controllers\master;

use Illuminate\Http\Request;
use App\Models\daerah\Provinsi;
use App\Models\daerah\Kabupaten;
use App\Http\Controllers\Controller;

class ProvinsiController extends Controller
{
    // Tampilkan daftar provinsi
   public function index()
{
    $provinsi = Provinsi::withCount('kabupaten') // Asumsi ada relasi kabupaten
        ->orderBy('nama')
        ->paginate(10);

    $totalKabupaten = Kabupaten::count(); // Total semua kabupaten

    return view('provinsi.index', compact('provinsi', 'totalKabupaten'));
}

    // Form tambah provinsi
    public function create()
    {
        return view('provinsi.create');
    }

    // Simpan provinsi baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:provinsi,nama',
        ]);

        Provinsi::create($request->all());

        return redirect()->route('provinsi.index')->with('success', 'Provinsi berhasil ditambahkan.');
    }

    // Form edit provinsi
    public function edit(Provinsi $provinsi)
    {
        return view('provinsi.edit', compact('provinsi'));
    }

    // Update provinsi
    public function update(Request $request, Provinsi $provinsi)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:provinsi,nama,' . $provinsi->id,
        ]);

        $provinsi->update($request->all());

        return redirect()->route('provinsi.index')->with('success', 'Provinsi berhasil diperbarui.');
    }

    // Hapus provinsi
    public function destroy(Provinsi $provinsi)
    {
        $provinsi->delete();
        return redirect()->route('provinsi.index')->with('success', 'Provinsi berhasil dihapus.');
    }

    // Ambil data provinsi untuk AJAX (opsional)
    public function getAll()
    {
        $provinsi = Provinsi::orderBy('nama')->get();
        return response()->json($provinsi);
    }
}
