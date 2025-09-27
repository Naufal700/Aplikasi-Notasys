<?php

namespace App\Models\jenisakta;

use App\Models\tipeakta\TipeAkta;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JenisAkta extends Model
{
    use HasFactory;

    protected $table = 'jenis_akta';

    protected $fillable = [
        'tipe_akta_id',
        'nama_akta',
    ];

    public function tipe()
    {
        return $this->belongsTo(TipeAkta::class, 'tipe_akta_id');
    }
}
