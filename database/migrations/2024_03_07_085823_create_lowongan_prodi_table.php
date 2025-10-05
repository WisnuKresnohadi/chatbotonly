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
        Schema::create('lowongan_prodi', function (Blueprint $table) {
            $table->string('id_lowongan')->nullable();
            $table->string('id_prodi')->nullable();
            $table->foreign('id_lowongan')->references('id_lowongan')->on('lowongan_magang');
            $table->foreign('id_prodi')->references('id_prodi')->on('program_studi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lowongan_prodi');
    }
};
