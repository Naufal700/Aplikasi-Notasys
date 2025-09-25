<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('klien_dokumen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('klien_id')->constrained('klien')->cascadeOnDelete();
            $table->string('jenis')->nullable();
            $table->string('nama')->nullable();
            $table->string('file_path')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('klien_dokumen');
    }
};
