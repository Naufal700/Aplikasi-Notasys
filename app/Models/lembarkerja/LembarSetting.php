<?php

namespace App\Models\lembarkerja;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LembarSetting extends Model
{
    use HasFactory;

    protected $table = 'lembar_setting';

    protected $fillable = [
        'lembar_kerja_id',
        'template_form_order_id',
        'form_order_akta_ppat',
        'form_order_proses_lainnya',
        'form_order_legalisasi',
        'form_order_akta_notaris_lainnya',
        'form_order_akta_notaris',
        'form_order_pajak_titipan',
        'form_order_waarmarking',
        'form_order_akta_ppat_luar_wilayah'
    ];

    protected $casts = [
        'form_order_akta_ppat' => 'boolean',
        'form_order_proses_lainnya' => 'boolean',
        'form_order_legalisasi' => 'boolean',
        'form_order_akta_notaris_lainnya' => 'boolean',
        'form_order_akta_notaris' => 'boolean',
        'form_order_pajak_titipan' => 'boolean',
        'form_order_waarmarking' => 'boolean',
        'form_order_akta_ppat_luar_wilayah' => 'boolean',
    ];

    public function lembarKerja()
    {
        return $this->belongsTo(LembarKerja::class);
    }

    public function templateFormOrder()
    {
        return $this->belongsTo(TemplateFormOrder::class);
    }
}
