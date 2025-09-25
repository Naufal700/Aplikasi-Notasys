<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('lembar_setting', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lembar_kerja_id')->constrained('lembar_kerja')->onDelete('cascade');
            $table->foreignId('template_form_order_id')->nullable()->constrained('template_form_order')->onDelete('set null');
            $table->json('opsi_form_order')->nullable(); // untuk radio button options
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('lembar_setting');
    }
};
