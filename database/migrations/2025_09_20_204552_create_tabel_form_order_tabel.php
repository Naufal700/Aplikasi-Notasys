<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('lembar_form_order', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lembar_kerja_id')
                  ->constrained('lembar_kerja') // perbaiki nama tabel
                  ->onDelete('cascade');
            $table->string('jenis_akta');
            $table->string('no_akta');
            $table->date('tgl_akta');
            $table->decimal('biaya', 15, 2);
            $table->date('tgl_akad')->nullable();
            $table->string('pihak_yang_mengalihkan')->nullable();
            $table->string('pihak_menerima')->nullable();
            $table->string('file_path')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('lembar_form_order');
    }
};
