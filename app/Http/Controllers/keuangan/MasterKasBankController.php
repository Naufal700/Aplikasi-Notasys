<?php

namespace App\Http\Controllers\keuangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\keuangan\MasterKasBank;

class MasterKasBankController extends Controller
{
    // Tampilkan daftar Kas & Bank
public function index(Request $request)
{
    $query = MasterKasBank::query();

    if ($request->search) {
        $query->where(function($q) use ($request) {
            $q->where('nama_akun', 'like', "%{$request->search}%")
              ->orWhere('nama_bank', 'like', "%{$request->search}%");
        });
    }

    if ($request->jenis) {
        $query->where('jenis', $request->jenis);
    }

    // Ganti get() dengan paginate(10)
    $data = $query->orderBy('jenis', 'asc')->paginate(10);

    // Agar pagination tetap bawa parameter search & jenis
    $data->appends($request->all());

    return view('lembarkerja.keuangan.master.index', compact('data'));
}
    // Form tambah
    public function create()
    {
        return view('lembarkerja.keuangan.master.form');
    }

    // Simpan data
    public function store(Request $request)
    {
        $request->validate([
            'jenis' => 'required|in:Kas,Bank',
            'nama_akun' => 'required_if:jenis,Kas|string|max:255',
            'nama_bank' => 'required_if:jenis,Bank|string|max:255',
            'atas_nama' => 'required_if:jenis,Bank|string|max:255',
            'nomor_rekening' => 'required_if:jenis,Bank|string|max:50',
        ]);

        // Siapkan data sesuai jenis
        $data = $request->jenis === 'Kas'
            ? [
                'jenis' => 'Kas',
                'nama_akun' => $request->nama_akun,
                'nama_bank' => null,
                'atas_nama' => null,
                'nomor_rekening' => null,
            ]
            : [
                'jenis' => 'Bank',
                'nama_akun' => null, // string kosong supaya NOT NULL tidak error
                'nama_bank' => $request->nama_bank,
                'atas_nama' => $request->atas_nama,
                'nomor_rekening' => $request->nomor_rekening,
            ];

        MasterKasBank::create($data);

        return redirect()->route('master.kasbank.index')
                         ->with('success', 'Data Kas & Bank berhasil disimpan');
    }

    // Form edit
    public function edit($id)
    {
        $item = MasterKasBank::findOrFail($id);
        return view('lembarkerja.keuangan.master.form', compact('item'));
    }

    // Update data
    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis' => 'required|in:Kas,Bank',
            'nama_akun' => 'required_if:jenis,Kas|string|max:255',
            'nama_bank' => 'required_if:jenis,Bank|string|max:255',
            'atas_nama' => 'required_if:jenis,Bank|string|max:255',
            'nomor_rekening' => 'required_if:jenis,Bank|string|max:50',
        ]);

        $item = MasterKasBank::findOrFail($id);

        $data = $request->jenis === 'Kas'
            ? [
                'jenis' => 'Kas',
                'nama_akun' => $request->nama_akun,
                'nama_bank' => null,
                'atas_nama' => null,
                'nomor_rekening' => null,
            ]
            : [
                'jenis' => 'Bank',
                'nama_akun' => null, // string kosong supaya NOT NULL tidak error
                'nama_bank' => $request->nama_bank,
                'atas_nama' => $request->atas_nama,
                'nomor_rekening' => $request->nomor_rekening,
            ];

        $item->update($data);

        return redirect()->route('master.kasbank.index')
                         ->with('success', 'Data Kas & Bank berhasil diperbarui');
    }

    // Hapus data
    public function destroy($id)
    {
        $item = MasterKasBank::findOrFail($id);
        $item->delete();

        return redirect()->route('master.kasbank.index')
                         ->with('success', 'Data Kas & Bank berhasil dihapus');
    }
}
