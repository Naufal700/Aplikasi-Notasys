<?php

namespace App\Models\klien;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KlienDokumen extends Model
{
    use HasFactory;

    protected $table = 'klien_dokumen';

    protected $fillable = [
        'klien_id',
        'jenis',
        'nama',
        'file_path',
        'catatan'
    ];

    // Relasi ke klien
    public function klien()
    {
        return $this->belongsTo(Klien::class, 'klien_id');
    }
}
