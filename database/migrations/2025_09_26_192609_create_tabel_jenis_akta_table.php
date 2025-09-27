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
        Schema::create('jenis_akta', function (Blueprint $table) {
            $table->id();
          $table->foreignId('tipe_akta_id')->constrained('tipe_akta')->onDelete('cascade');
            $table->string('nama_akta', 150);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_akta');
    }
};
