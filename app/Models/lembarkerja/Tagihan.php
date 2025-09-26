<?php

namespace App\Models\lembarkerja;

use App\Models\lembarkerja\LembarKerja;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tagihan extends Model
{
    use HasFactory;

    protected $table = 'tagihan';

    protected $fillable = [
        'lembar_kerja_id',
        'tanggal',
        'jenis',
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
}
