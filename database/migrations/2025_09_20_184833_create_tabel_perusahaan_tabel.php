<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perusahaan', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_lembaga', 50);
            $table->string('nama_lembaga');
            $table->string('email')->nullable();
            $table->string('telp_kantor')->nullable();
            $table->string('nama_pic')->nullable();
            $table->string('no_telp_pic')->nullable();
            
            // Tanggal buat & update tanpa jam
            $table->date('created_at')->nullable();
            $table->date('updated_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perusahaan');
    }
};
