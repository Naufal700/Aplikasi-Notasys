<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bank_leasing', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lembaga');
            $table->string('cabang');
            $table->string('no_pks', 100)->nullable();
            $table->date('tanggal_berakhir_pks')->nullable();

            // Marketing
            $table->string('nama_marketing')->nullable();
            $table->string('no_hp_marketing', 20)->nullable();

            // ADK
            $table->string('nama_adk')->nullable();
            $table->string('no_hp_adk', 20)->nullable();

            // Legal
            $table->string('nama_legal')->nullable();
            $table->string('no_hp_legal', 20)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bank_leasing');
    }
};
