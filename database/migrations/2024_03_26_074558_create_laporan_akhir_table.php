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
        Schema::create('laporan_akhir', function (Blueprint $table) {
            $table->uuid('id_lap_akhir')->primary();
            $table->uuid('id_jenismagang')->nullable()->default(null);
            $table->dateTime('deadline_pengumpulan');
            $table->dateTime('deadline_penilaian');
            $table->boolean('status')->default(true);
            $table->uuid('id_year_akademik')->nullable()->default(null);
            $table->foreign('id_jenismagang')->references('id_jenismagang')->on('jenis_magang');
            $table->foreign('id_year_akademik')->references('id_year_akademik')->on('tahun_akademik');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_akhir');
    }
};
