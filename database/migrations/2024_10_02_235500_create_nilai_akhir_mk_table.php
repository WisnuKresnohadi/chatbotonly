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
        Schema::create('nilai_akhir_mk', function (Blueprint $table) {
            $table->uuid('id_nilai_akhir_mk')->primary();
            $table->string('nim');
            $table->string('kode_mk', 255);
            $table->string('semester', 20);
            $table->string('nilai_mk', 5);
            $table->foreign('nim')->references('nim')->on('mahasiswa');
            $table->foreign('kode_mk')->references('kode_mk')->on('mata_kuliah');            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_akhir_mk');
    }
};
