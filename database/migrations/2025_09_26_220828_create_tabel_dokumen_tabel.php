<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dokumen', function (Blueprint $table) {
            $table->id();
            $table->string('menu'); // menu / fitur, misal 'klien', 'lembar_kerja'
            $table->unsignedBigInteger('menu_id'); // ID record terkait
            $table->foreignId('jenis_dokumen_id')->constrained('jenis_dokumen');
            $table->string('nama'); // nama dokumen
            $table->string('file_path'); // path file
            $table->text('catatan')->nullable(); // catatan opsional
            $table->foreignId('uploaded_by')->nullable()->constrained('users');
            $table->timestamps();

            $table->index(['menu','menu_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumen');
    }
};
