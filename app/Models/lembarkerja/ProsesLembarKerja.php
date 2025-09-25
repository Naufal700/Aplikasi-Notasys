<?php

namespace App\Models\lembarkerja;

use App\Models\lembarkerja\LembarKerja;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProsesLembarKerja extends Model
{
    use HasFactory;

    protected $table = 'proses_lembar_kerja';

    protected $fillable = [
        'lembar_kerja_id',
        'nama_proses',
        'target_selesai',
        'selesai',
        'urutan',
        'catatan',
    ];

    protected $casts = [
        'selesai' => 'boolean',
        'target_selesai' => 'date',
    ];

    /**
     * Relasi ke LembarKerja
     */
    public function lembarKerja()
    {
        return $this->belongsTo(LembarKerja::class, 'lembar_kerja_id');
    }
}
