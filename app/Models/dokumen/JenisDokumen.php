<?php

namespace App\Models\dokumen;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisDokumen extends Model
{
    use HasFactory;

    protected $table = 'jenis_dokumen';

    protected $fillable = [
        'nama_dokumen',
    ];

    // Relasi ke dokumen
    public function dokumen()
    {
        return $this->hasMany(Dokumen::class, 'jenis_dokumen_id');
    }
}
