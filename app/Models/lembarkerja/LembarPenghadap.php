<?php

namespace App\Models\lembarkerja;

use App\Models\klien\Klien;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LembarPenghadap extends Model
{
    use HasFactory;

    protected $table = 'lembar_penghadap';

    protected $fillable = [
        'lembar_kerja_id',
        'klien_id'
    ];

    public function lembarKerja()
    {
        return $this->belongsTo(LembarKerja::class);
    }

    public function klien()
    {
        return $this->belongsTo(Klien::class);
    }
}
