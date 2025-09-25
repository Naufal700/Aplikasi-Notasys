<?php

namespace App\Models\daerah;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kabupaten extends Model
{
    use HasFactory;

    protected $table = 'kabupaten';

    protected $fillable = [
        'provinsi_id',
        'nama'
    ];

    // Relasi ke provinsi
    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'provinsi_id');
    }

    // Relasi ke kota
    public function kota()
    {
        return $this->hasMany(Kota::class, 'kabupaten_id');
    }
}
