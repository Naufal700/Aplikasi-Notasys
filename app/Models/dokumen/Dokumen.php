<?php

namespace App\Models\dokumen;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dokumen extends Model
{
    use HasFactory;

    protected $table = 'dokumen';

    protected $fillable = [
        'menu',
        'menu_id',
        'jenis_dokumen_id',
        'nama',
        'file_path',
        'catatan',
        'uploaded_by',
    ];

    // Relasi ke jenis dokumen
    public function jenis()
    {
        return $this->belongsTo(JenisDokumen::class, 'jenis_dokumen_id');
    }

    // Relasi ke user uploader
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
