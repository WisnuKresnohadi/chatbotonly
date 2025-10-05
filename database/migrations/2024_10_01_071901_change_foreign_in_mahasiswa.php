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
        if (Schema::hasIndex('mahasiswa', 'mahasiswa_kode_dosen_foreign')) {
            Schema::table('mahasiswa', function (Blueprint $table) {
                $table->dropForeign(['kode_dosen']);
            });
        }
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->foreign('kode_dosen')->references('kode_dosen')->on('dosen')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->dropForeign(['kode_dosen']);
        });
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->foreign('kode_dosen')->references('kode_dosen')->on('dosen');
        });
    }
};
