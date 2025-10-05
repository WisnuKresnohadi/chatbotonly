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
        Schema::create('mhs_magang', function (Blueprint $table) {
            $table->uuid('id_mhsmagang')->primary();
            $table->uuid('id_pendaftaran');
            $table->integer('nim');
            $table->integer('nip');
            $table->uuid('id_pemblap');
            $table->integer('nilai_akhir_magang');
            $table->string('indeks_nilai_akhir_magang', 255);
            $table->foreign('id_pendaftaran')->references('id_pendaftaran')->on('pendaftaran_magang');
            $table->foreign('nim')->references('nim')->on('mahasiswa');
            $table->foreign('nip')->references('nip')->on('dosen');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mhs_magang');
    }
};