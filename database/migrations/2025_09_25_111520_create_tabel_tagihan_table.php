<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tagihan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lembar_kerja_id')->constrained('lembar_kerja')->onDelete('cascade');
            $table->date('tanggal');
            $table->string('jenis'); // misal: Tagihan
            $table->decimal('total_tagihan', 15, 2);
            $table->date('jatuh_tempo');
            $table->string('metode_pembayaran'); // Transfer / Tunai / EDC
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tagihan');
    }
};
