<?php

namespace App\Models\keuangan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeuanganKategori extends Model
{
    use HasFactory;

    protected $table = 'keuangan_kategori';

    protected $fillable = [
        'nama_kategori',
    ];

    // Relasi ke Tagihan
    public function tagihan()
    {
        return $this->hasMany(\App\Models\lembarkerja\Tagihan::class, 'kategori_id');
    }
}
