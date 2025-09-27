<?php

namespace App\Models\master;

use App\Models\daerah\Provinsi;
use App\Models\daerah\Kabupaten;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Partner extends Model
{
    use HasFactory;

    protected $table = 'partners';

    protected $fillable = [
        'nama',
        'provinsi_id',
        'kabupaten_id',
        'email',
        'alamat_lengkap',
        'pic_nama',
        'pic_jabatan',
        'pic_keterangan',
    ];

    // Relasi ke Provinsi
    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'provinsi_id');
    }

    // Relasi ke Kabupaten
    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class, 'kabupaten_id');
    }
}
