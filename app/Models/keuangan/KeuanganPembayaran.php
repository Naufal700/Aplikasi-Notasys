<?php

namespace App\Models\keuangan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\lembarkerja\Tagihan;

class KeuanganPembayaran extends Model
{
    use HasFactory;

    protected $table = 'keuangan_pembayaran';

    protected $fillable = [
        'tagihan_id',
        'tanggal_bayar',
        'nominal_bayar',
        'metode_bayar',
        'keterangan',
    ];

    // Relasi ke Tagihan
    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class, 'tagihan_id');
    }
}
