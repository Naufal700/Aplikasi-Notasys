<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profil_notaris', function (Blueprint $table) {
            $table->id();
            $table->string('nama_notaris', 100);
            $table->string('nama_pejabat', 100)->nullable();
            $table->string('no_telepon', 50)->nullable();
            $table->string('no_fax', 50)->nullable();
            $table->string('email', 100)->nullable();

            $table->string('sk_notaris', 100)->nullable();
            $table->date('tgl_sk_notaris')->nullable();

            $table->string('sk_ppat', 100)->nullable();
            $table->date('tgl_sk_ppat')->nullable();

            $table->string('area_kerja_notaris', 100)->nullable();
            $table->string('area_kerja_ppat', 100)->nullable();

            $table->unsignedBigInteger('provinsi_id')->nullable();
            $table->unsignedBigInteger('kabupaten_id')->nullable();

            $table->text('alamat')->nullable();
            $table->text('header_alamat')->nullable();
            $table->string('zona_waktu', 50)->nullable();

            $table->string('logo')->nullable();

            $table->timestamps();

            $table->foreign('provinsi_id')->references('id')->on('provinsi')->onDelete('set null');
            $table->foreign('kabupaten_id')->references('id')->on('kabupaten')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profil_notaris');
    }
};
