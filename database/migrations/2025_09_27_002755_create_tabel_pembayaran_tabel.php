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
       Schema::create('keuangan_pembayaran', function (Blueprint $table) {
    $table->id();
    $table->foreignId('tagihan_id')->constrained('tagihan')->cascadeOnDelete();
    $table->date('tanggal_bayar');
    $table->decimal('nominal_bayar', 15, 2);
    $table->string('metode_bayar')->nullable();
    $table->text('keterangan')->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keuangan_pembayaran');
    }
};
