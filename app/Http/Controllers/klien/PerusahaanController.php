<?php

namespace App\Http\Controllers\klien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\klien\Perusahaan;
use Carbon\Carbon;

class PerusahaanController extends Controller
{
    // Daftar perusahaan dengan filter (optional)
    public function index(Request $request)
    {
        $query = Perusahaan::query();

        // Filter jenis lembaga
        if ($request->filled('jenis_lembaga')) {
            $query->where('jenis_lembaga', $request->jenis_lembaga);
        }

        // Filter tanggal buat dari
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('created_at', '>=', $request->tanggal_dari);
        }

        // Filter tanggal buat sampai
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_sampai);
        }

        $perusahaans = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('perusahaan.index', compact('perusahaans'));
    }

    // Form tambah perusahaan
    public function create()
    {
        $jenisLembaga = ['PT', 'CV', 'Koperasi', 'Yayasan']; // contoh dropdown
        return view('perusahaan.create', compact('jenisLembaga'));
    }

    // Simpan perusahaan baru
    public function store(Request $request)
    {
        $request->validate([
            'jenis_lembaga' => 'required|string',
            'nama_lembaga' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'telp_kantor' => 'nullable|string|max:50',
            'nama_pic' => 'nullable|string|max:255',
            'no_telp_pic' => 'nullable|string|max:50',
        ]);

        Perusahaan::create([
            'jenis_lembaga' => $request->jenis_lembaga,
            'nama_lembaga' => $request->nama_lembaga,
            'email' => $request->email,
            'telp_kantor' => $request->telp_kantor,
            'nama_pic' => $request->nama_pic,
            'no_telp_pic' => $request->no_telp_pic,
            'created_at' => Carbon::now()->format('Y-m-d'),
            'updated_at' => Carbon::now()->format('Y-m-d'),
        ]);

        return redirect()->route('perusahaan.index')->with('success', 'Perusahaan berhasil ditambahkan');
    }

    // Form edit perusahaan
    public function edit($id)
    {
        $perusahaan = Perusahaan::findOrFail($id);
        $jenisLembaga = ['PT', 'CV', 'Koperasi', 'Yayasan'];
        return view('perusahaan.edit', compact('perusahaan', 'jenisLembaga'));
    }

    // Update perusahaan
    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis_lembaga' => 'required|string',
            'nama_lembaga' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'telp_kantor' => 'nullable|string|max:50',
            'nama_pic' => 'nullable|string|max:255',
            'no_telp_pic' => 'nullable|string|max:50',
        ]);

        $perusahaan = Perusahaan::findOrFail($id);
        $perusahaan->update([
            'jenis_lembaga' => $request->jenis_lembaga,
            'nama_lembaga' => $request->nama_lembaga,
            'email' => $request->email,
            'telp_kantor' => $request->telp_kantor,
            'nama_pic' => $request->nama_pic,
            'no_telp_pic' => $request->no_telp_pic,
            'updated_at' => Carbon::now()->format('Y-m-d'),
        ]);

        return redirect()->route('perusahaan.index')->with('success', 'Perusahaan berhasil diperbarui');
    }

    // Hapus perusahaan
    public function destroy($id)
    {
        $perusahaan = Perusahaan::findOrFail($id);
        $perusahaan->delete();

        return redirect()->route('perusahaan.index')->with('success', 'Perusahaan berhasil dihapus');
    }
}
