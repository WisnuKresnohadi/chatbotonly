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
        if (Schema::hasColumn('laporan_akhir', 'durasi_magang') && Schema::hasColumn('laporan_akhir', 'berkas_magang')) {
            Schema::table('laporan_akhir', function (Blueprint $table) {
                $table->dropColumn('durasi_magang');
                $table->dropColumn('berkas_magang');
            });
        } else {
            Schema::table('laporan_akhir', function (Blueprint $table) {
                $table->string('durasi_magang', 100);
                $table->json('berkas_magang')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('laporan_akhir', 'durasi_magang') && Schema::hasColumn('laporan_akhir', 'berkas_magang')) {
            Schema::table('laporan_akhir', function (Blueprint $table) {
                $table->dropColumn('durasi_magang');
                $table->dropColumn('berkas_magang');
            });
        }
    }
};
