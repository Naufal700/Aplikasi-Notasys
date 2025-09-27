<?php

namespace App\Http\Controllers\klien;

use App\Http\Controllers\Controller;
use App\Models\daerah\Kota;
use App\Models\daerah\Kabupaten;
use App\Models\daerah\Provinsi;
use App\Models\klien\Klien;
use App\Models\klien\KlienDokumen;
use App\Models\klien\BankLeasing;
use App\Models\klien\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KlienController extends Controller
{
    // Tampilkan list klien
    public function index(Request $request)
    {
        $query = Klien::with(['provinsi', 'kabupaten', 'kota', 'dokumen', 'bankLeasing', 'perusahaan']);

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('nama', 'like', '%'.$request->search.'%')
                  ->orWhere('email', 'like', '%'.$request->search.'%');
            });
        }

        if ($request->tipe) {
            $query->where('tipe', $request->tipe);
        }

        if ($request->provinsi) {
            $query->where('provinsi_id', $request->provinsi);
        }

        if ($request->kabupaten) {
            $query->where('kabupaten_id', $request->kabupaten);
        }

        if ($request->tanggal_dari) {
            $query->whereDate('created_at', '>=', $request->tanggal_dari);
        }

        if ($request->tanggal_sampai) {
            $query->whereDate('created_at', '<=', $request->tanggal_sampai);
        }

        $klien = $query->paginate(10)->withQueryString();

        $provinsiList = Provinsi::all();
        $kabupatenList = Kabupaten::all();

        return view('klien.index', compact('klien', 'provinsiList', 'kabupatenList'));
    }

    // Form create klien
    public function create()
    {
        $provinsi = Provinsi::orderBy('nama')->get();
        $bankLeasing = BankLeasing::orderBy('nama_lembaga')->get();
        $perusahaan = Perusahaan::orderBy('nama_lembaga')->get();
        return view('klien.create', compact('provinsi', 'bankLeasing', 'perusahaan'));
    }

    // Simpan data klien
    public function store(Request $request)
    {
        $request->validate([
            'tipe' => 'required|in:pribadi,bank_leasing,perusahaan',
            'nama' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:50',
            'email' => 'nullable|email',
            'npwp' => 'nullable|string|max:50',
            'status_perkawinan' => 'nullable|in:belum_menikah,menikah,cerai',
            'no_ktp' => 'nullable|string|max:50',
            'tgl_lahir' => 'nullable|date',
            'provinsi_id' => 'nullable|exists:provinsi,id',
            'kabupaten_id' => 'nullable|exists:kabupaten,id',
            'kota_id' => 'nullable|exists:kota,id',
            'alamat_ktp' => 'nullable|string',
            'catatan' => 'nullable|string',
            'lainnya' => 'nullable|string',
            'bank_leasing_id' => 'nullable|exists:bank_leasing,id',
            'perusahaan_id' => 'nullable|exists:perusahaan,id'
        ]);

        DB::beginTransaction();

        try {
            $klien = Klien::create($request->all());

            // Simpan dokumen jika ada
            if($request->has('dokumen') && is_array($request->dokumen)) {
                foreach($request->dokumen as $dok) {
                    if(isset($dok['file']) && $dok['file'] instanceof \Illuminate\Http\UploadedFile) {
                        $filePath = $dok['file']->store('dokumen_klien', 'public');
                        KlienDokumen::create([
                            'klien_id' => $klien->id,
                            'jenis' => $dok['jenis'] ?? null,
                            'nama' => $dok['nama'] ?? null,
                            'file_path' => $filePath,
                            'catatan' => $dok['catatan'] ?? null
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('klien.index')->with('success', 'Klien berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors($e->getMessage());
        }
    }

    // Tampilkan detail klien
    public function show(Klien $klien)
    {
        $klien->load(['provinsi', 'kabupaten', 'kota', 'dokumen', 'bankLeasing', 'perusahaan']);
        return view('klien.show', compact('klien'));
    }

    // Form edit klien
    public function edit($id)
    {
        $klien = Klien::with(['dokumen', 'kabupaten', 'bankLeasing', 'perusahaan'])->findOrFail($id);
        $provinsi = Provinsi::all();
        $bankLeasing = BankLeasing::all();
        $perusahaan = Perusahaan::all();

        return view('klien.edit', compact('klien', 'provinsi', 'bankLeasing', 'perusahaan'));
    }

    // Update klien
    public function update(Request $request, Klien $klien)
    {
        $request->validate([
            'tipe' => 'required|in:pribadi,bank_leasing,perusahaan',
            'nama' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:50',
            'email' => 'nullable|email',
            'npwp' => 'nullable|string|max:50',
            'status_perkawinan' => 'nullable|in:belum_menikah,menikah,cerai',
            'no_ktp' => 'nullable|string|max:50',
            'tgl_lahir' => 'nullable|date',
            'provinsi_id' => 'nullable|exists:provinsi,id',
            'kabupaten_id' => 'nullable|exists:kabupaten,id',
            'kota_id' => 'nullable|exists:kota,id',
            'alamat_ktp' => 'nullable|string',
            'catatan' => 'nullable|string',
            'lainnya' => 'nullable|string',
            'bank_leasing_id' => 'nullable|exists:bank_leasing,id',
            'perusahaan_id' => 'nullable|exists:perusahaan,id'
        ]);

        DB::beginTransaction();

        try {
            $klien->update($request->all());

            if($request->has('dokumen') && is_array($request->dokumen)) {
                foreach($request->dokumen as $dok) {
                    if(isset($dok['file']) && $dok['file'] instanceof \Illuminate\Http\UploadedFile) {
                        $filePath = $dok['file']->store('dokumen_klien', 'public');
                        KlienDokumen::create([
                            'klien_id' => $klien->id,
                            'jenis' => $dok['jenis'] ?? null,
                            'nama' => $dok['nama'] ?? null,
                            'file_path' => $filePath,
                            'catatan' => $dok['catatan'] ?? null
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('klien.index')->with('success', 'Klien berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors($e->getMessage());
        }
    }

    // Hapus klien
    public function destroy(Klien $klien)
    {
        $klien->delete();
        return redirect()->route('klien.index')->with('success', 'Klien berhasil dihapus.');
    }

    // Ambil kabupaten berdasarkan provinsi
    public function getKabupaten(Request $request)
    {
        $provinsiId = $request->provinsi_id;

        $kabupaten = $provinsiId
            ? Kabupaten::where('provinsi_id', $provinsiId)->orderBy('nama')->get()
            : Kabupaten::orderBy('nama')->get();

        return response()->json(['data' => $kabupaten]);
    }

    // Ambil kota berdasarkan kabupaten
    public function getKota(Request $request)
    {
        $kabupatenId = $request->kabupaten_id;

        $kota = $kabupatenId
            ? Kota::where('kabupaten_id', $kabupatenId)->orderBy('nama')->get()
            : Kota::orderBy('nama')->get();

        return response()->json(['data' => $kota]);
    }

    // Search provinsi
    public function searchProvinsi(Request $request)
    {
        $q = $request->get('q');
        $data = \DB::table('provinsi')->where('nama', 'like', "%{$q}%")->get();
        return response()->json(['data' => $data]);
    }

    // Search kabupaten
    public function searchKabupaten(Request $request)
    {
        $q = $request->get('q');
        $provinsi_id = $request->get('provinsi_id');
        $query = \DB::table('kabupaten')->where('nama', 'like', "%{$q}%");
        if($provinsi_id) $query->where('provinsi_id', $provinsi_id);
        $data = $query->get();
        return response()->json(['data' => $data]);
    }

    // Search kota
    public function searchKota(Request $request)
    {
        $q = $request->get('q');
        $kabupaten_id = $request->get('kabupaten_id');
        $query = \DB::table('kota')->where('nama', 'like', "%{$q}%");
        if($kabupaten_id) $query->where('kabupaten_id', $kabupaten_id);
        $data = $query->get();
        return response()->json(['data' => $data]);
    }
    // Controller Dashboard Pelanggan
  public function dashboard(Request $request)
{
    // Ambil bulan yang dipilih dari query string, default bulan ini
    $selectedMonth = $request->get('month', date('m'));

    // Array bulan untuk dropdown
    $months = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];

    // Total semua klien di bulan terpilih
    $total = Klien::whereMonth('created_at', $selectedMonth)->count();

    // Total per tipe di bulan terpilih
    $pribadi = Klien::where('tipe', 'pribadi')->whereMonth('created_at', $selectedMonth)->count();
    $bankLeasing = Klien::where('tipe', 'bank_leasing')->whereMonth('created_at', $selectedMonth)->count();
    $perusahaan = Klien::where('tipe', 'perusahaan')->whereMonth('created_at', $selectedMonth)->count();

    // Data untuk tabel per tipe di bulan terpilih
    $pribadiData = Klien::where('tipe', 'pribadi')->whereMonth('created_at', $selectedMonth)->orderBy('created_at', 'desc')->get();
    $bankLeasingData = Klien::where('tipe', 'bank_leasing')->whereMonth('created_at', $selectedMonth)->orderBy('created_at', 'desc')->get();
    $perusahaanData = Klien::where('tipe', 'perusahaan')->whereMonth('created_at', $selectedMonth)->orderBy('created_at', 'desc')->get();

    // Pertumbuhan bulanan (jumlah klien baru per bulan, tahun ini)
    $monthlyGrowth = Klien::selectRaw('EXTRACT(MONTH FROM created_at) as bulan, COUNT(*) as total')
        ->whereYear('created_at', date('Y'))
        ->groupBy('bulan')
        ->orderBy('bulan')
        ->pluck('total', 'bulan')
        ->toArray();

    // Lengkapi 12 bulan agar Jan–Des selalu ada
    $growthData = [];
    for ($i = 1; $i <= 12; $i++) {
        $growthData[] = $monthlyGrowth[$i] ?? 0;
    }

    // Kirim semua data ke view
    return view('klien.dashboard', compact(
        'total', 'pribadi', 'bankLeasing', 'perusahaan',
        'pribadiData', 'bankLeasingData', 'perusahaanData',
        'growthData', 'months', 'selectedMonth'
    ));
}
}
