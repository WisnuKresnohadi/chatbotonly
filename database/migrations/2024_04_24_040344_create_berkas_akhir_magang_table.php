<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('berkas_akhir_magang', function (Blueprint $table) {
            $table->uuid('id_berkas_akhir_magang')->primary();
            $table->uuid('id_lap_akhir')->nullable();
            $table->uuid('id_mhsmagang')->nullable();
            $table->text('berkas_file')->nullable();
            $table->string('berkas_magang', 255)->nullable();
            $table->string('status_berkas', 255)->nullable();
            $table->dateTime('tgl_upload')->nullable()->default(now());
            $table->foreign('id_lap_akhir')->references('id_lap_akhir')->on('laporan_akhir');
            $table->foreign('id_mhsmagang')->references('id_mhsmagang')->on('mhs_magang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berkas_akhir_magang');
    }
};
