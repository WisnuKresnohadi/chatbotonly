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
        Schema::create('info_tambahan', function (Blueprint $table) {
            $table->uuid('id_infotab')->primary();
            $table->string('nim');
            $table->string('lok_kerja', 255)->nullable();
            $table->string('sosmed', 255)->nullable();
            $table->uuid('id_bahasa');
            $table->foreign('id_bahasa')->references('id_bahasa')->on('bahasa');
            $table->foreign('nim')->references('nim')->on('mahasiswa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('info_tambahan');
    }
};
