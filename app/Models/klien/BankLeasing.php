<?php

namespace App\Models\klien;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankLeasing extends Model
{
    use HasFactory;

    protected $table = 'bank_leasing';

    // Field yang boleh diisi secara mass-assignment
    protected $fillable = [
        'nama_lembaga',
        'cabang',
        'no_pks',
        'tanggal_berakhir_pks',
        'nama_marketing',
        'no_hp_marketing',
        'nama_adk',
        'no_hp_adk',
        'nama_legal',
        'no_hp_legal',
    ];

    // Jika ingin otomatis mengubah format tanggal
    protected $dates = [
        'tanggal_berakhir_pks',
        'created_at',
        'updated_at',
    ];
}
