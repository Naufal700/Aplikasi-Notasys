<?php

namespace App\Models\keuangan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterKasBank extends Model
{
    use HasFactory;

    protected $table = 'master_kas_bank';

    protected $fillable = [
        'nama_akun',
        'jenis',
        'nama_bank',
        'atas_nama',
        'nomor_rekening'
    ];
}
