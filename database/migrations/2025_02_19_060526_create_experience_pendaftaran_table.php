<?php

use App\Models\Mahasiswa;
use Illuminate\Database\Eloquent\Model;
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
        Schema::dropIfExists('experience_pendaftaran');
        Schema::create('experience_pendaftaran', callback: function (Blueprint $table) {
            $table->uuid('id_experience')->primary();
            $table->uuid('id_pendaftaran');
            $table->string('nim', 255);
            $table->string('posisi', 255)->nullable();
            $table->string('jenis', 255)->nullable();
            $table->string('name_intitutions', 255)->nullable();
            $table->date('startdate');
            $table->date('enddate');
            $table->string('deskripsi', 255)->nullable();
            $table->string('nama', 255)->nullable();
            $table->string('prestasi', 255)->nullable();
            $table->string('kategori', 255)->nullable();
            $table->foreign('id_pendaftaran')->references('id_pendaftaran')->on('pendaftaran_magang')->cascadeOnDelete();
            $table->foreign('nim')->references('nim')->on('mahasiswa')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experience_pendaftaran');
    }
};
