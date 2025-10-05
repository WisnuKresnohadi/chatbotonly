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
        Schema::table('dokumen_pendaftaran_magang', function (Blueprint $table) {
            $table->foreign('id_pendaftaran')->references('id_pendaftaran')->on('pendaftaran_magang')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dokumen_pendaftaran_magang', function (Blueprint $table) {
            $table->dropForeign(['id_pendaftaran']);
        });
    }
};
