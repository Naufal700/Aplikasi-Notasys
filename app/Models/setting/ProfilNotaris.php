<?php

namespace App\Models\setting;

use App\Models\daerah\Provinsi;
use App\Models\daerah\Kabupaten;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProfilNotaris extends Model
{
    use HasFactory;

    protected $table = 'profil_notaris';

    protected $fillable = [
        'nama_notaris','nama_pejabat','no_telepon','no_fax','email',
        'sk_notaris','tgl_sk_notaris','sk_ppat','tgl_sk_ppat',
        'area_kerja_notaris','area_kerja_ppat','provinsi_id','kabupaten_id',
        'alamat','zona_waktu','logo'
    ];

    protected $dates = ['tgl_sk_notaris','tgl_sk_ppat'];

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'provinsi_id');
    }

    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class, 'kabupaten_id');
    }
}
