<?php

namespace App\Http\Controllers\klien;

use Illuminate\Http\Request;
use App\Models\klien\BankLeasing;
use App\Http\Controllers\Controller;

class BankLeasingController extends Controller
{
    // Menampilkan daftar bank/leasing dengan filter
    public function index(Request $request)
    {
        $query = BankLeasing::query();

        // Filter cabang
        if ($request->filled('cabang')) {
            $query->where('cabang', 'ilike', '%' . $request->cabang . '%'); // ilike untuk case-insensitive PostgreSQL
        }

        // Filter tanggal buat (created_at)
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('created_at', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_sampai);
        }

        $bankLeasings = $query->orderBy('id', 'desc')->paginate(10);

        return view('bank-leasing.index', compact('bankLeasings'));
    }

    // Form tambah data
    public function create()
    {
        return view('bank-leasing.create');
    }

    // Simpan data baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lembaga' => 'required|string|max:255',
            'cabang' => 'required|string|max:255',
            'no_pks' => 'nullable|string|max:100',
            'tanggal_berakhir_pks' => 'nullable|date',
            'nama_marketing' => 'nullable|string|max:255',
            'no_hp_marketing' => 'nullable|string|max:20',
            'nama_adk' => 'nullable|string|max:255',
            'no_hp_adk' => 'nullable|string|max:20',
            'nama_legal' => 'nullable|string|max:255',
            'no_hp_legal' => 'nullable|string|max:20',
        ]);

        BankLeasing::create($validated);

        return redirect()->route('bank-leasing.index')->with('success', 'Data berhasil disimpan.');
    }

    // Form edit data
    public function edit(BankLeasing $bankLeasing)
    {
        return view('bank-leasing.edit', compact('bankLeasing'));
    }

    // Update data
    public function update(Request $request, BankLeasing $bankLeasing)
    {
        $validated = $request->validate([
            'nama_lembaga' => 'required|string|max:255',
            'cabang' => 'required|string|max:255',
            'no_pks' => 'nullable|string|max:100',
            'tanggal_berakhir_pks' => 'nullable|date',
            'nama_marketing' => 'nullable|string|max:255',
            'no_hp_marketing' => 'nullable|string|max:20',
            'nama_adk' => 'nullable|string|max:255',
            'no_hp_adk' => 'nullable|string|max:20',
            'nama_legal' => 'nullable|string|max:255',
            'no_hp_legal' => 'nullable|string|max:20',
        ]);

        $bankLeasing->update($validated);

        return redirect()->route('bank-leasing.index')->with('success', 'Data berhasil diperbarui.');
    }

    // Hapus data
    public function destroy(BankLeasing $bankLeasing)
    {
        $bankLeasing->delete();
        return redirect()->route('bank-leasing.index')->with('success', 'Data berhasil dihapus.');
    }
}
