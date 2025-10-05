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
        Schema::create('mhs_nilai_magang', function (Blueprint $table) {
            $table->uuid('id_mhs_nilai_magang')->primary();
            $table->uuid('id_mhsmagang');
            $table->uuid('id_kompnilai');
            $table->uuid('id_nilai');
            $table->foreign('id_mhsmagang')->references('id_mhsmagang')->on('mhs_magang');
            $table->foreign('id_kompnilai')->references('id_kompnilai')->on('komponen_nilai');
            $table->foreign('id_nilai')->references('id_nilai')->on('nilai_mutu');
            $table->double('nilai_magang')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mhs_nilai_magang');
    }
};