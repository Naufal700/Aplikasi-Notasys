<?php

namespace App\Http\Controllers\setting;
use Illuminate\Http\Request;
use App\Models\daerah\Provinsi;
use App\Models\daerah\Kabupaten;
use App\Http\Controllers\Controller;
use App\Models\setting\ProfilNotaris;

class SettingController extends Controller
{
    /**
     * Tampilkan halaman setting dengan tab
     */
    public function index()
    {
        $profil = ProfilNotaris::first();
        $provinsi = Provinsi::orderBy('nama')->get();
        $zonaWaktu = \DateTimeZone::listIdentifiers();

        return view('setting.index', compact('profil','provinsi','zonaWaktu'));
    }

    /**
     * Simpan / update Profil Notaris
     */
    public function saveProfilNotaris(Request $request)
    {
        $validated = $request->validate([
            'nama_notaris'=>'required|string|max:100',
            'nama_pejabat'=>'nullable|string|max:100',
            'no_telepon'=>'nullable|string|max:50',
            'no_fax'=>'nullable|string|max:50',
            'email'=>'nullable|email|max:100',
            'sk_notaris'=>'nullable|string|max:100',
            'tgl_sk_notaris'=>'nullable|date',
            'sk_ppat'=>'nullable|string|max:100',
            'tgl_sk_ppat'=>'nullable|date',
            'area_kerja_notaris'=>'nullable|string|max:100',
            'area_kerja_ppat'=>'nullable|string|max:100',
            'provinsi_id'=>'nullable|exists:provinsi,id',
            'kabupaten_id'=>'nullable|exists:kabupaten,id',
            'alamat'=>'nullable|string',
                    'zona_waktu'=>'nullable|string',
            'logo'=>'nullable|image|mimes:png,jpg,jpeg|max:2048'
        ]);

        // Upload logo jika ada
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $fileName = 'logo_notaris.' . $file->getClientOriginalExtension();
            $file->storeAs('public/uploads', $fileName);
            $validated['logo'] = $fileName;
        }

        $profil = ProfilNotaris::first();
        if ($profil) {
            $profil->update($validated);
        } else {
            ProfilNotaris::create($validated);
        }

        return redirect()->back()->with('success','Profil Notaris berhasil disimpan');
    }

    /**
     * Ambil kabupaten berdasarkan provinsi (AJAX)
     */
    public function getKabupaten(Request $request)
    {
        $kabupaten = Kabupaten::where('provinsi_id',$request->provinsi_id)
                      ->orderBy('nama')->get();
        return response()->json($kabupaten);
    }
}
