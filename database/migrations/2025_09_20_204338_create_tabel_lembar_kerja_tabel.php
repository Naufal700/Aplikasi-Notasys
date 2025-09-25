<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('lembar_kerja', function (Blueprint $table) {
            $table->id();
            $table->string('no_pesanan')->unique();
            $table->date('tgl_pesanan');
            $table->foreignId('klien_id')->constrained('klien')->onDelete('cascade');
            $table->string('tipe_pelanggan');
            $table->string('nama_lembar');
            $table->foreignId('layanan_id')->constrained('layanan')->onDelete('cascade');
            $table->date('tgl_target')->nullable();
            $table->text('keterangan')->nullable();

            // Kolom status dengan enum
            $table->enum('status', ['draft', 'proses', 'persetujuan', 'dibatalkan', 'selesai'])->default('draft');

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('lembar_kerja');
    }
};
