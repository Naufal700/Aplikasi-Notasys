<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('master_kas_bank', function (Blueprint $table) {
            $table->id();
            $table->string('nama_akun'); // Nama Kas / Nama Akun Bank
            $table->enum('jenis', ['Kas','Bank']); // Jenis akun
            $table->string('nama_bank')->nullable(); // Nama bank jika jenis Bank
            $table->string('atas_nama')->nullable(); // Atas nama rekening
            $table->string('nomor_rekening')->nullable(); // Nomor rekening
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_kas_bank');
    }
};
