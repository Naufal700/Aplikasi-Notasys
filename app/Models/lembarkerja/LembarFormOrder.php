<?php

namespace App\Models\lembarkerja;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LembarFormOrder extends Model
{
    use HasFactory;

    protected $table = 'lembar_form_order';

    protected $fillable = [
        'lembar_kerja_id',
        'jenis_akta',
        'no_akta',
        'tgl_akta',
        'biaya',
        'tgl_akad',
        'pihak_yang_mengalihkan',
        'pihak_menerima',
        'file_path',
        'catatan'
    ];

    public function lembarKerja()
    {
        return $this->belongsTo(LembarKerja::class);
    }
}
