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
        Schema::table('mhs_magang', function (Blueprint $table) {
            $table->tinyInteger('status_magang')->default(1)->comment('1: Active 0: Nonactive');
            $table->longText('alasan_pemulangan')->nullable();
            $table->string('berkas_pemulangan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mhs_magang', function (Blueprint $table) {
            $table->dropColumn('status_magang');
            $table->dropColumn('alasan_pemulangan');
            $table->dropColumn('berkas_pemulangan');
        });
    }
};
