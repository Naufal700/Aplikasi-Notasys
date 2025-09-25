<?php

namespace App\Models\klien;

use App\Models\daerah\Kota;
use App\Models\daerah\Provinsi;
use App\Models\daerah\Kabupaten;
use App\Models\klien\KlienDokumen;
use App\Models\klien\BankLeasing;
use App\Models\klien\Perusahaan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Klien extends Model
{
    use HasFactory;

    protected $table = 'klien';

    protected $fillable = [
        'tipe',
        'nama',
        'email',
        'npwp',
        'status_perkawinan',
        'no_telepon',
        'no_ktp',
        'tgl_lahir',
        'provinsi_id',
        'kabupaten_id',
        'kota_id',
        'alamat_ktp',
        'catatan',
        'lainnya',
        'bank_leasing_id',
        'perusahaan_id',
    ];

    protected $casts = [
        'tgl_lahir' => 'date',
    ];

    // Relasi ke dokumen
    public function dokumen()
    {
        return $this->hasMany(KlienDokumen::class, 'klien_id');
    }

    // Relasi ke provinsi
    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'provinsi_id');
    }

    // Relasi ke kabupaten
    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class, 'kabupaten_id');
    }

    // Relasi ke kota
    public function kota()
    {
        return $this->belongsTo(Kota::class, 'kota_id');
    }

    // Relasi ke bank leasing
    public function bankLeasing()
    {
        return $this->belongsTo(BankLeasing::class, 'bank_leasing_id');
    }

    // Relasi ke perusahaan
    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'perusahaan_id');
    }
}
