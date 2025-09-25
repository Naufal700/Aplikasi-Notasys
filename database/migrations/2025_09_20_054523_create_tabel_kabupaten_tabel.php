<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kabupaten', function (Blueprint $table) {
            $table->id();
            $table->foreignId('provinsi_id')->constrained('provinsi')->cascadeOnDelete();
            $table->string('nama');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kabupaten');
    }
};
