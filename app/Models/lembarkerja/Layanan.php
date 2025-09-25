<?php

namespace App\Models\lembarkerja;

use App\Models\lembarkerja\LembarKerja;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Layanan extends Model
{
    use HasFactory;

    protected $table = 'layanan'; // pastikan sesuai nama tabel
    protected $fillable = [
        'nama',
        'deskripsi', // opsional, kalau ada kolom tambahan
    ];

    // Relasi ke LembarKerja
    public function lembarKerja()
    {
        return $this->hasMany(LembarKerja::class, 'layanan_id');
    }
}
