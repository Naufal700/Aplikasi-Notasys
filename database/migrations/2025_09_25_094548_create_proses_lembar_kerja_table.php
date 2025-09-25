<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proses_lembar_kerja', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('lembar_kerja_id')
                  ->constrained('lembar_kerja')
                  ->onDelete('cascade');
            $table->string('nama_proses');
            $table->date('target_selesai')->nullable();
            $table->boolean('selesai')->default(false);
            $table->integer('urutan')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proses_lembar_kerja');
    }
};
