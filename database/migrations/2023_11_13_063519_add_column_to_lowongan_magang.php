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
        Schema::table('lowongan_magang', function (Blueprint $table) {
            $table->uuid('id_prodi');
            $table->foreign('id_prodi')->references('id_prodi')->on('program_studi');
            $table->uuid('id_fakultas');
            $table->foreign('id_fakultas')->references('id_fakultas')->on('fakultas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lowongan_magang', function (Blueprint $table) {
            //
        });
    }
};
