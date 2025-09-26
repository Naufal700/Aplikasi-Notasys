<?php

namespace App\Models\lembarkerja;

use App\Models\klien\Klien;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LembarKerja extends Model
{
    use HasFactory;

    protected $table = 'lembar_kerja';

    protected $fillable = [
        'no_pesanan',
        'tgl_pesanan',
        'klien_id',
        'tipe_pelanggan',
        'nama_lembar',
        'layanan_id',
        'tgl_target',
        'keterangan',
        'status',
    ];

    // Relasi ke Klien
    public function klien()
    {
        return $this->belongsTo(Klien::class);
    }

    // Relasi ke Layanan
    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }

    // Relasi ke Penghadap
   public function penghadap()
{
    return $this->belongsToMany(Klien::class, 'lembar_penghadap', 'lembar_kerja_id', 'klien_id');
}


    // Relasi ke Setting
    public function setting()
    {
        return $this->hasOne(LembarSetting::class);
    }

    // Relasi ke Form Order
    public function formOrders()
    {
        return $this->hasMany(LembarFormOrder::class);
    }

    /**
     * Nilai default untuk status
     */
    protected $attributes = [
        'status' => 'draft',
    ];
    public function proses()
{
    return $this->hasMany(ProsesLembarKerja::class, 'lembar_kerja_id');
}
public function tagihan()
{
    return $this->hasMany(Tagihan::class);
}
}
