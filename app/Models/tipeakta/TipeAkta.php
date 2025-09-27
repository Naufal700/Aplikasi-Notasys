<?php

namespace App\Models\tipeakta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipeAkta extends Model
{
    use HasFactory;

    protected $table = 'tipe_akta';
    protected $fillable = ['nama_tipe'];

    // Relasi ke JenisAkta
    public function jenisAkta()
    {
        return $this->hasMany(\App\Models\jenisakta\JenisAkta::class, 'tipe_akta_id');
    }
}
