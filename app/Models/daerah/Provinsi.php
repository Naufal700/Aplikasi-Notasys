<?php

namespace App\Models\daerah;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    use HasFactory;

    protected $table = 'provinsi';

    protected $fillable = [
        'nama'
    ];

    // Relasi ke kabupaten
    public function kabupaten()
    {
        return $this->hasMany(Kabupaten::class, 'provinsi_id');
    }
}
