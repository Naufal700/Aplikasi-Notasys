<?php

namespace App\Models\lembarkerja;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateFormOrder extends Model
{
    use HasFactory;

    protected $table = 'template_form_order';

    protected $fillable = [
        'nama_template',
        'deskripsi',
    ];

    public function lembarSetting()
    {
        return $this->hasMany(LembarSetting::class);
    }
}
