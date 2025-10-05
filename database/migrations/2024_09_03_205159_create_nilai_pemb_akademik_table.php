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
        Schema::create('nilai_pemb_akademik', function (Blueprint $table) {
            $table->uuid('id_nilai_pemb_akademik')->nullable();

            $table->uuid('id_mhsmagang')->nullable();
            $table->uuid('id_kompnilai')->nullable();

            $table->foreign('id_mhsmagang')->references('id_mhsmagang')->on('mhs_magang');
            $table->foreign('id_kompnilai')->references('id_kompnilai')->on('komponen_nilai');

            $table->integer('nilai')->nullable();
            $table->string('oleh')->nullable();
            $table->date('dateinputnilai')->nullable();
            $table->string('aspek_penilaian')->nullable();
            $table->integer('nilai_max')->nullable();
            $table->longText('deskripsi_penilaian')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_pemb_akademik');
    }
};
