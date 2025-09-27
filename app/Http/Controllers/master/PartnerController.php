<?php

namespace App\Http\Controllers\master;
use Illuminate\Http\Request;
use App\Models\master\Partner;
use App\Models\daerah\Provinsi;
use App\Models\daerah\Kabupaten;
use App\Http\Controllers\Controller;

class PartnerController extends Controller
{
    // Tampilkan daftar partner
   public function index(Request $request)
{
    $query = Partner::with(['provinsi','kabupaten']);

    if($request->search){
        $query->where('nama','like','%'.$request->search.'%')
              ->orWhere('email','like','%'.$request->search.'%');
    }

    if($request->provinsi_id){
        $query->where('provinsi_id', $request->provinsi_id);
    }

    if($request->kabupaten_id){
        $query->where('kabupaten_id', $request->kabupaten_id);
    }

    $partners = $query->paginate(10);

    // untuk filter dropdown
    $provinsiList = Provinsi::all();
    $kabupatenList = $request->provinsi_id ? Kabupaten::where('provinsi_id',$request->provinsi_id)->get() : Kabupaten::all();

    return view('partners.index', compact('partners','provinsiList','kabupatenList'));
}
    // Form tambah partner
    public function create()
    {
        $provinsi = Provinsi::all();
        return view('partners.create', compact('provinsi'));
    }

    // Simpan data partner
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'provinsi_id' => 'required|exists:provinsi,id',
            'kabupaten_id' => 'required|exists:kabupaten,id',
            'email' => 'nullable|email|max:255',
            'alamat_lengkap' => 'nullable|string',
            'pic_nama' => 'nullable|string|max:255',
            'pic_jabatan' => 'nullable|string|max:255',
            'pic_keterangan' => 'nullable|string',
        ]);

        Partner::create($request->all());

        return redirect()->route('partners.index')->with('success', 'Partner berhasil ditambahkan.');
    }

    // Form edit partner
    public function edit(Partner $partner)
    {
        $provinsi = Provinsi::all();
        $kabupaten = Kabupaten::where('provinsi_id', $partner->provinsi_id)->get();
        return view('partners.edit', compact('partner', 'provinsi', 'kabupaten'));
    }

    // Update partner
    public function update(Request $request, Partner $partner)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'provinsi_id' => 'required|exists:provinsi,id',
            'kabupaten_id' => 'required|exists:kabupaten,id',
            'email' => 'nullable|email|max:255',
            'alamat_lengkap' => 'nullable|string',
            'pic_nama' => 'nullable|string|max:255',
            'pic_jabatan' => 'nullable|string|max:255',
            'pic_keterangan' => 'nullable|string',
        ]);

        $partner->update($request->all());

        return redirect()->route('partners.index')->with('success', 'Partner berhasil diperbarui.');
    }

    // Hapus partner
    public function destroy(Partner $partner)
    {
        $partner->delete();
        return redirect()->route('partners.index')->with('success', 'Partner berhasil dihapus.');
    }

    // Ambil kabupaten berdasarkan provinsi (AJAX)
    public function getKabupaten($provinsi_id)
    {
        $kabupaten = Kabupaten::where('provinsi_id', $provinsi_id)->get();
        return response()->json($kabupaten);
    }
}
