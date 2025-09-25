<?php

namespace App\Models\klien;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perusahaan extends Model
{
    use HasFactory;

    protected $table = 'perusahaan';

    // Disable timestamps default Laravel karena kita pakai date saja
    public $timestamps = false;

    // Field yang bisa diisi mass-assignment
    protected $fillable = [
        'jenis_lembaga',
        'nama_lembaga',
        'email',
        'telp_kantor',
        'nama_pic',
        'no_telp_pic',
        'created_at',
        'updated_at',
    ];
}
