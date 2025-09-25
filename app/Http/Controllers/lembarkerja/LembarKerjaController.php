<?php

namespace App\Http\Controllers\lembarkerja;

use App\Models\klien\Klien;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\lembarkerja\Layanan;
use App\Http\Controllers\Controller;
use App\Models\lembarkerja\LembarKerja;
use App\Models\lembarkerja\LembarSetting;
use App\Models\lembarkerja\LembarFormOrder;
use App\Models\lembarkerja\LembarPenghadap;
use App\Models\lembarkerja\ProsesLembarKerja;
use App\Models\lembarkerja\TemplateFormOrder;

class LembarKerjaController extends Controller
{
    // Tampilkan daftar lembar kerja
   public function index(Request $request)
{
    $query = LembarKerja::with('klien', 'layanan');

    if($request->search){
        $query->where('nama_lembar', 'ilike', "%{$request->search}%")
              ->orWhere('no_pesanan', 'ilike', "%{$request->search}%");
    }

    if($request->tgl_awal && $request->tgl_akhir){
        $query->whereBetween('tgl_pesanan', [$request->tgl_awal, $request->tgl_akhir]);
    }

    if($request->status){
        $query->where('status', $request->status);
    }

    if($request->layanan_id){
        $query->where('layanan_id', $request->layanan_id);
    }

    if($request->tipe_pelanggan){
        $query->where('tipe_pelanggan', $request->tipe_pelanggan);
    }

    $lembarKerja = $query->orderBy('tgl_pesanan', 'desc')->paginate(10);

    $layanan = Layanan::all();

    return view('lembarKerja.index', compact('lembarKerja','layanan'));
}


    // Form Create
    public function create()
    {
        $klien = Klien::select('id','nama','tipe')->get();
        $layanan = Layanan::all();
        $templates = TemplateFormOrder::all();

        // Generate No Pesanan otomatis
        $noPesanan = 'LK-' . date('Ymd') . '-' . Str::upper(Str::random(4));

        // Opsi Form Order untuk radio button di tab Setting
        $opsiFormOrder = [
            'akta_ppat', 
            'proses_lainnya', 
            'legalisasi', 
            'akta_notaris_lainnya', 
            'akta_notaris', 
            'pajak_titipan', 
            'waarmarking', 
            'akta_ppat_luar_wilayah'
        ];

        return view('lembarKerja.create', compact('klien', 'layanan', 'templates', 'noPesanan', 'opsiFormOrder'));
    }

    // Simpan Lembar Kerja
    public function store(Request $request)
    {
        $request->validate([
            'tgl_pesanan' => 'required|date',
            'klien_id' => 'required|exists:klien,id',
            'nama_lembar' => 'required|string|max:255',
            'layanan_id' => 'required|exists:layanan,id',
            'tgl_target' => 'nullable|date',
            'keterangan' => 'nullable|string',
            'penghadap' => 'required|array',
            'penghadap.*' => 'exists:klien,id',
            'template_form_order_id' => 'nullable|exists:template_form_order,id',
            'form_order.*.jenis_akta' => 'required|string',
            'form_order.*.no_akta' => 'required|string',
            'form_order.*.tgl_akta' => 'required|date',
            'form_order.*.biaya' => 'required|numeric',
        ]);

        // Simpan Lembar Kerja
        $lembarKerja = LembarKerja::create([
            'no_pesanan' => $request->no_pesanan,
            'tgl_pesanan' => $request->tgl_pesanan,
            'klien_id' => $request->klien_id,
            'tipe_pelanggan' => $request->tipe_pelanggan, // otomatis di frontend
            'nama_lembar' => $request->nama_lembar,
            'layanan_id' => $request->layanan_id,
            'tgl_target' => $request->tgl_target,
            'keterangan' => $request->keterangan,
            'status' => 'draft', // <-- status default draft
        ]);

        // Simpan Penghadap
        foreach ($request->penghadap as $klienId) {
            LembarPenghadap::create([
                'lembar_kerja_id' => $lembarKerja->id,
                'klien_id' => $klienId
            ]);
        }

        // Opsi Form Order
        $opsiFields = [
            'form_order_akta_ppat',
            'form_order_proses_lainnya',
            'form_order_legalisasi',
            'form_order_akta_notaris_lainnya',
            'form_order_akta_notaris',
            'form_order_pajak_titipan',
            'form_order_waarmarking',
            'form_order_akta_ppat_luar_wilayah'
        ];

        $settingData = ['lembar_kerja_id' => $lembarKerja->id, 'template_form_order_id' => $request->template_form_order_id];

        foreach($opsiFields as $field){
            $settingData[$field] = $request->input($field, 0); // default 0 jika tidak diisi
        }

        // Simpan Setting
        LembarSetting::create($settingData);

        // Simpan Form Order
        if($request->has('form_order')) {
            foreach($request->form_order as $fo) {
                LembarFormOrder::create(array_merge($fo, [
                    'lembar_kerja_id' => $lembarKerja->id
                ]));
            }
        }

        return redirect()->route('lembar-kerja.index')->with('success', 'Lembar Kerja berhasil dibuat dengan status DRAFT.');
    }

    // Form Edit
  public function edit(LembarKerja $lembarKerja)
{
    $klien = Klien::select('id','nama','tipe')->get();
    $layanan = Layanan::all();
    $templates = TemplateFormOrder::all();

    // Opsi Form Order radio button
    $opsiFormOrder = [
        'akta_ppat', 
        'proses_lainnya', 
        'legalisasi', 
        'akta_notaris_lainnya', 
        'akta_notaris', 
        'pajak_titipan', 
        'waarmarking', 
        'akta_ppat_luar_wilayah'
    ];

    $lembarKerja->load('penghadap', 'setting', 'formOrders');

    // ✅ Ambil klien_id dari relasi penghadap
    $selectedPenghadap = $lembarKerja->penghadap->pluck('klien_id')->toArray();

    $aktaList = ['Akta Jual Beli', 'Akta Hibah', 'Akta Waris', 'Akta Pendirian PT'];

    return view('lembarKerja.edit', compact(
        'lembarKerja',
        'klien',
        'layanan',
        'templates',
        'opsiFormOrder',
        'aktaList',
        'selectedPenghadap'
    ));
}
    // Update Lembar Kerja
    public function update(Request $request, LembarKerja $lembarKerja)
    {
        $request->validate([
            'tgl_pesanan' => 'required|date',
            'klien_id' => 'required|exists:klien,id',
            'nama_lembar' => 'required|string|max:255',
            'layanan_id' => 'required|exists:layanan,id',
            'tgl_target' => 'nullable|date',
            'keterangan' => 'nullable|string',
            'penghadap' => 'required|array',
            'penghadap.*' => 'exists:klien,id',
        ]);

        $lembarKerja->update([
            'tgl_pesanan' => $request->tgl_pesanan,
            'klien_id' => $request->klien_id,
            'tipe_pelanggan' => $request->tipe_pelanggan,
            'nama_lembar' => $request->nama_lembar,
            'layanan_id' => $request->layanan_id,
            'tgl_target' => $request->tgl_target,
            'keterangan' => $request->keterangan,
            // Status tidak berubah saat update kecuali ingin diubah manual
        ]);

        // Update Penghadap
        $lembarKerja->penghadap()->delete();
        foreach ($request->penghadap as $klienId) {
            LembarPenghadap::create([
                'lembar_kerja_id' => $lembarKerja->id,
                'klien_id' => $klienId
            ]);
        }

        $opsiFields = [
            'form_order_akta_ppat',
            'form_order_proses_lainnya',
            'form_order_legalisasi',
            'form_order_akta_notaris_lainnya',
            'form_order_akta_notaris',
            'form_order_pajak_titipan',
            'form_order_waarmarking',
            'form_order_akta_ppat_luar_wilayah'
        ];

        // Ambil input radio button
        $opsiFormOrder = $request->input('opsi_form_order', []);

        // Mapping ke 't' / 'f'
        $settingData = ['template_form_order_id' => $request->template_form_order_id];
        foreach ($opsiFields as $index => $field) {
            $settingData[$field] = ($opsiFormOrder[$index] ?? 'Tidak') === 'Ya' ? 't' : 'f';
        }

        $lembarKerja->setting()->updateOrCreate(
            ['lembar_kerja_id' => $lembarKerja->id],
            $settingData
        );

        // Update Form Order
        if($request->has('form_order')) {
            $lembarKerja->formOrders()->delete();
            foreach($request->form_order as $fo) {
                LembarFormOrder::create(array_merge($fo, [
                    'lembar_kerja_id' => $lembarKerja->id
                ]));
            }
        }

        return redirect()->route('lembar-kerja.index')->with('success', 'Lembar Kerja berhasil diupdate.');
    }

    // Delete
    public function destroy(LembarKerja $lembarKerja)
    {
        $lembarKerja->delete();
        return redirect()->route('lembar-kerja.index')->with('success', 'Lembar Kerja berhasil dihapus.');
    }
    public function monitoring(Request $request)
    {
        $tab = $request->tab ?? 'lembar_kerja';
        $search = $request->search;
        $filterDate = $request->filter_date ?? 'all';

        $query = LembarKerja::with('klien');

        // Filter search
        if($search) {
            $query->where(function($q) use ($search) {
                $q->where('no_pesanan', 'ilike', "%$search%")
                  ->orWhere('nama_lembar', 'ilike', "%$search%")
                  ->orWhereHas('klien', function($q2) use ($search){
                      $q2->where('nama', 'ilike', "%$search%");
                  });
            });
        }
$today = now()->startOfDay();
$tomorrow = $today->copy()->addDay();
$threeDays = $today->copy()->addDays(3);
$fourDays = $today->copy()->addDays(4);
$sevenDays = $today->copy()->addDays(7);

if($filterDate === 'today') {
    $query->where(function($q) use ($today) {
        $q->whereDate('tgl_pesanan', $today)
          ->orWhereDate('tgl_target', $today);
    });
} elseif($filterDate === '3days') {
    $query->where(function($q) use ($tomorrow, $threeDays) {
        $q->whereBetween('tgl_pesanan', [$tomorrow, $threeDays])
          ->orWhereBetween('tgl_target', [$tomorrow, $threeDays]);
    });
} elseif($filterDate === '7days') {
    $query->where(function($q) use ($fourDays, $sevenDays) {
        $q->whereBetween('tgl_pesanan', [$fourDays, $sevenDays])
          ->orWhereBetween('tgl_target', [$fourDays, $sevenDays]);
    });
}

        $lembarKerja = $query->orderBy('tgl_target', 'asc')->paginate(10)->withQueryString();

        return view('lembarKerja.monitoring', compact('lembarKerja', 'tab', 'search', 'filterDate'));
    }
   public function uploadFile(Request $request)
{
    $request->validate([
        'file' => 'required|file|max:10240', // max 10MB
    ]);

    $file = $request->file('file');
    $fileName = time() . '_' . $file->getClientOriginalName();
    $path = $file->storeAs('public/lembar-kerja', $fileName);

    return response()->json([
        'status' => 'success',
        'file_path' => $path,
        'file_name' => $fileName,
    ]);
}
// Ambil semua proses untuk lembar kerja tertentu
   public function getProses(LembarKerja $lembarKerja)
{
    $proses = $lembarKerja->proses()->orderBy('urutan')->get();

    return response()->json([
        'status' => 'success',
        'proses' => $proses
    ]);
}


    // Simpan proses baru
    public function storeProses(Request $request, LembarKerja $lembarKerja)
    {
        $request->validate([
            'nama_proses' => 'required|string|max:255',
            'target_selesai' => 'nullable|date',
            'selesai' => 'nullable|boolean',
            'urutan' => 'nullable|integer',
            'catatan' => 'nullable|string',
        ]);

        $proses = ProsesLembarKerja::create([
            'lembar_kerja_id' => $lembarKerja->id,
            'nama_proses' => $request->nama_proses,
            'target_selesai' => $request->target_selesai,
            'selesai' => $request->selesai ?? false,
            'urutan' => $request->urutan,
            'catatan' => $request->catatan,
        ]);

        return response()->json(['status' => 'success', 'proses' => $proses]);
    }

    // Update proses
    public function updateProses(Request $request, ProsesLembarKerja $proses)
    {
        $request->validate([
            'nama_proses' => 'required|string|max:255',
            'target_selesai' => 'nullable|date',
            'selesai' => 'nullable|boolean',
            'urutan' => 'nullable|integer',
            'catatan' => 'nullable|string',
        ]);

        $proses->update([
            'nama_proses' => $request->nama_proses,
            'target_selesai' => $request->target_selesai,
            'selesai' => $request->selesai ?? false,
            'urutan' => $request->urutan,
            'catatan' => $request->catatan,
        ]);

        return response()->json(['status' => 'success', 'proses' => $proses]);
    }

    // Hapus proses
    public function destroyProses(ProsesLembarKerja $proses)
    {
        $proses->delete();
        return response()->json(['status' => 'success']);
    }
    public function showProses($prosesId)
{
    $proses = ProsesLembarKerja::find($prosesId);
    if ($proses) {
        return response()->json([
            'status' => 'success',
            'data' => $proses
        ]);
    } else {
        return response()->json([
            'status' => 'error',
            'message' => 'Proses tidak ditemukan'
        ], 404);
    }
}

}
