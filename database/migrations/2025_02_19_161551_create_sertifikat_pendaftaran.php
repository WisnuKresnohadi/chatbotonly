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
        Schema::create('sertifikat_pendaftaran', function (Blueprint $table) {
            $table->uuid('id_sertif')->primary();
            $table->uuid('id_pendaftaran');
            $table->string('nim', 255);
            $table->string('nama_sertif', 255)->nullable();
            $table->string('penerbit', 255)->nullable();
            $table->date('startdate');
            $table->date('enddate');
            $table->string('file_sertif', 255)->nullable();
            $table->string('link_sertif', 255)->nullable();
            $table->string('deskripsi', 255)->nullable();
            $table->foreign('id_pendaftaran')->references('id_pendaftaran')->on('pendaftaran_magang')->cascadeOnDelete();
            $table->foreign('nim')->references('nim')->on('mahasiswa')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sertifikat_pendaftaran');
    }
};
