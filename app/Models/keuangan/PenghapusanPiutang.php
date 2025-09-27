<?php

namespace App\Models\keuangan;

use App\Models\lembarkerja\Tagihan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PenghapusanPiutang extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'piutang_hapus';

    // Kolom yang bisa diisi massal
    protected $fillable = [
        'id_tagihan',
        'tanggal',
        'nominal',
        'keterangan',
    ];

    /**
     * Relasi ke Tagihan
     */
    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class, 'id_tagihan');
    }
}
