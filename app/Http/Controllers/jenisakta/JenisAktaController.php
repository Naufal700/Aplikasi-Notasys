<?php

namespace App\Http\Controllers\jenisakta;

use Illuminate\Http\Request;
use App\Models\tipeakta\TipeAkta;
use App\Models\jenisakta\JenisAkta;
use App\Http\Controllers\Controller;

class JenisAktaController extends Controller
{
public function index()
{
    $data = \App\Models\jenisakta\JenisAkta::with('tipe')
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    return view('jenis.akta.index', compact('data'));
}
    public function create()
    {
        $tipe_akta = TipeAkta::all();
        return view('jenis.akta.create', compact('tipe_akta'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipe_akta_id' => 'required|exists:tipe_akta,id',
            'nama_akta'    => 'required|string|max:150',
        ]);

        JenisAkta::create([
            'tipe_akta_id' => $request->tipe_akta_id,
            'nama_akta'    => $request->nama_akta,
        ]);

        return redirect()->route('jenis.akta.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit(JenisAkta $jenis_akta)
    {
        $tipe_akta = TipeAkta::all();
        return view('jenis.akta.edit', compact('jenis_akta', 'tipe_akta'));
    }

    public function update(Request $request, JenisAkta $jenis_akta)
    {
        $request->validate([
            'tipe_akta_id' => 'required|exists:tipe_akta,id',
            'nama_akta'    => 'required|string|max:150',
        ]);

        $jenis_akta->update([
            'tipe_akta_id' => $request->tipe_akta_id,
            'nama_akta'    => $request->nama_akta,
        ]);

        return redirect()->route('jenis.akta.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy(JenisAkta $jenis_akta)
    {
        $jenis_akta->delete();
        return redirect()->route('jenis.akta.index')->with('success', 'Data berhasil dihapus');
    }
}
