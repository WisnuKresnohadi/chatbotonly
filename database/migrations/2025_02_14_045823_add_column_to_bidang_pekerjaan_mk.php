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
        Schema::table('bidang_pekerjaan_mk', function (Blueprint $table) {
            $table->uuid('id_prodi')->after('id_bidang_pekerjaan_industri');
            $table->foreign('id_prodi')->references('id_prodi')->on('program_studi')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bidang_pekerjaan_mk', function (Blueprint $table) {
            //
        });
    }
};
