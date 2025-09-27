<?php

namespace App\Http\Controllers\keuangan;

use App\Http\Controllers\Controller;
use App\Models\keuangan\KeuanganKategori;
use App\Models\keuangan\KeuanganPembayaran;
use App\Models\keuangan\PenghapusanPiutang;
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
     // Method Dashboard Keuangan
  public function dashboard(Request $request)
{
    // Periode filter berdasarkan bulan
    $selectedMonth = $request->input('month') ?? now()->month;
    $selectedYear  = now()->year;

    $start_date = \Carbon\Carbon::create($selectedYear, $selectedMonth, 1)->startOfMonth();
    $end_date   = \Carbon\Carbon::create($selectedYear, $selectedMonth, 1)->endOfMonth();

    // Untuk dropdown bulan
    $months = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];

    // Total KPI
    $totalTagihan = Tagihan::whereBetween('tanggal', [$start_date, $end_date])->sum('total_tagihan');
    $totalPembayaran = KeuanganPembayaran::whereBetween('tanggal_bayar', [$start_date, $end_date])->sum('nominal_bayar');
    $penghapusanPiutang = PenghapusanPiutang::whereBetween('tanggal', [$start_date, $end_date])->sum('nominal');
    $sisaTagihan = $totalTagihan - $totalPembayaran - $penghapusanPiutang;

    // Chart Penerimaan Kas Mingguan
    $chartData = [];
    $period = \Carbon\CarbonPeriod::create($start_date, '1 week', $end_date);

   foreach($period as $date) {
    $weekStart = $date->copy()->startOfWeek();
    $weekEnd   = $date->copy()->endOfWeek();

    $mingguan = KeuanganPembayaran::whereBetween('tanggal_bayar', [
        $weekStart->toDateString(),
        $weekEnd->toDateString()
    ])->sum('nominal_bayar');

    $chartData[] = [
        'minggu' => $weekStart->format('d M') . ' - ' . $weekEnd->format('d M'),
        'masuk' => (int) $mingguan // pastikan integer
    ];
}

    // 5 Tagihan & 5 Pembayaran Terbaru
    $tagihanTerbaru = Tagihan::whereBetween('tanggal', [$start_date, $end_date])
                              ->orderBy('tanggal','desc')->take(5)->get();

    $pembayaranTerbaru = KeuanganPembayaran::whereBetween('tanggal_bayar', [$start_date, $end_date])
                              ->orderBy('tanggal_bayar','desc')->take(5)->get();

    return view('lembarkerja.keuangan.dashboard', compact(
        'totalTagihan','totalPembayaran','penghapusanPiutang','sisaTagihan',
        'chartData','tagihanTerbaru','pembayaranTerbaru',
        'months','selectedMonth'
    ));
}
}
