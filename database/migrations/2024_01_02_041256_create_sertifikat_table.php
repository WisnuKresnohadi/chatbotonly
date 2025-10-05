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
        Schema::create('sertifikat', function (Blueprint $table) {
            $table->uuid('id_sertif')->primary();
            $table->string('nim', 255);
            $table->string('nama_sertif', 255);
            $table->string('penerbit', 255);
            $table->date('startdate');
            $table->date('enddate');
            $table->string('file_sertif', 255)->nullable();
            $table->string('link_sertif', 255)->nullable();
            $table->string('deskripsi', 255)->nullable();
            $table->foreign('nim')->references('nim')->on('mahasiswa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sertifikat');
    }
};
