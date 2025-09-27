<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->foreignId('provinsi_id')->constrained('provinsi')->onDelete('cascade');
            $table->foreignId('kabupaten_id')->constrained('kabupaten')->onDelete('cascade');
            $table->string('email')->nullable();
            $table->text('alamat_lengkap')->nullable();

            // PIC Notaris
            $table->string('pic_nama')->nullable();
            $table->string('pic_jabatan')->nullable();
            $table->text('pic_keterangan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};
