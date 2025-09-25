<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('klien', function (Blueprint $table) {
            $table->id();
            $table->enum('tipe', ['pribadi', 'bank_leasing', 'perusahaan'])->default('pribadi');
            $table->string('nama');
            $table->string('email')->nullable();
            $table->string('npwp')->nullable();
            $table->enum('status_perkawinan', ['belum_menikah', 'menikah', 'cerai'])->default('belum_menikah');
            $table->string('no_telepon');
            $table->string('no_ktp')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->foreignId('provinsi_id')->nullable()->constrained('provinsi')->nullOnDelete();
            $table->foreignId('kabupaten_id')->nullable()->constrained('kabupaten')->nullOnDelete();
            $table->foreignId('bank_leasing_id')->nullable()->constrained('bank_leasing')->nullOnDelete();
$table->foreignId('perusahaan_id')->nullable()->constrained('perusahaan')->nullOnDelete();
            $table->foreignId('kota_id')->nullable()->constrained('kota')->nullOnDelete();
            $table->text('alamat_ktp')->nullable();
            $table->text('catatan')->nullable();
            $table->text('lainnya')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('klien');
    }
};
