<?php

namespace App\Models\lembarkerja;

use App\Models\lembarkerja\LembarKerja;
use Illuminate\Database\Eloquent\Model;
use App\Models\keuangan\KeuanganKategori;
use App\Models\keuangan\KeuanganPembayaran;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tagihan extends Model
{
    use HasFactory;

    protected $table = 'tagihan';

    protected $fillable = [
        'lembar_kerja_id',
        'kategori_id', // kategori sekarang wajib
        'tanggal',
        'total_tagihan',
        'jatuh_tempo',
        'metode_pembayaran',
        'keterangan',
    ];

    // Relasi ke LembarKerja
    public function lembarKerja()
    {
        return $this->belongsTo(LembarKerja::class, 'lembar_kerja_id');
    }

    // Relasi ke Kategori Keuangan
    public function kategori()
    {
        return $this->belongsTo(KeuanganKategori::class, 'kategori_id');
    }

    // Hitung sisa tagihan jika nanti ada tabel pembayaran
    public function getSisaAttribute()
    {
        if (method_exists($this, 'pembayaran')) {
            $totalBayar = $this->pembayaran()->sum('nominal');
            return $this->total_tagihan - $totalBayar;
        }
        return $this->total_tagihan;
    }

    // Relasi ke pembayaran (opsional jika sudah ada tabel pembayaran)
    public function pembayaran()
    {
        return $this->hasMany(KeuanganPembayaran::class, 'tagihan_id');
    }
}
