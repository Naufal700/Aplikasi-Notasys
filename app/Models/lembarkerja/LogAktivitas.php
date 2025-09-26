<?php

namespace App\Models\lembarkerja;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class LogAktivitas extends Model
{
    use HasFactory;

    protected $table = 'log_aktivitas';

    protected $fillable = [
        'user_id', 'aktivitas', 'detail'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
