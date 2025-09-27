<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('klien_dokumen', function (Blueprint $table) {
        $table->string('menu')->nullable();
        $table->unsignedBigInteger('menu_id')->nullable();
    });
}

public function down()
{
    Schema::table('klien_dokumen', function (Blueprint $table) {
        $table->dropColumn(['menu', 'menu_id']);
    });
}

};
