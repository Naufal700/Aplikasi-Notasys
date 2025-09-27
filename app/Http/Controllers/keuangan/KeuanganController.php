<?php

namespace App\Http\Controllers\keuangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\lembarkerja\Tagihan;

class KeuanganController extends Controller
{
    // Tampilkan daftar semua tagihan & pembayaran
    public function index()
    {
        $tagihan = Tagihan::with('lembarKerja.klien', 'kategori')
                    ->whereHas('kategori', function($q){
                        $q->whereIn('nama_kategori',['Tagihan','Bayar']);
                    })
                    ->orderBy('tanggal','asc')
                    ->get();

        return view('lembarkerja.keuangan.index', compact('tagihan'));
    }

    // Cetak Tagihan / Struk
    public function printTagihan($id)
    {
        $tagihan = Tagihan::with('lembarKerja.klien', 'kategori')->findOrFail($id);

        if($tagihan->kategori->nama_kategori === 'Tagihan'){
            // Tampilkan view invoice/tagihan
            return view('lembarkerja.keuangan.cetak_tagihan', compact('tagihan'));
        } else {
            // Tampilkan struk pembayaran
            return view('keuangan.cetak_struk', compact('tagihan'));
        }
    }
}
