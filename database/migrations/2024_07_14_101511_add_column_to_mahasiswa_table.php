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
        Schema::table('dosen', function (Blueprint $table) {
            $table->index('kode_dosen');
        });

        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->char('kode_dosen', 5)->nullable();
            $table->foreign('kode_dosen')->references('kode_dosen')->on('dosen');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->dropForeign(['kode_dosen']);
            $table->dropColumn('kode_dosen');
        });

        Schema::table('dosen', function (Blueprint $table) {
            $table->dropIndex(['kode_dosen']);
        });
    }
};
