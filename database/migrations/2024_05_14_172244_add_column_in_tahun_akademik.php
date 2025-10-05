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
        Schema::table('tahun_akademik', function (Blueprint $table) {
            $table->dateTime('startdate_daftar')->nullable();
            $table->dateTime('enddate_daftar')->nullable();
            $table->dateTime('startdate_pengumpulan_berkas')->nullable();
            $table->dateTime('enddate_pengumpulan_berkas')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tahun_akademik', function (Blueprint $table) {
            //
        });
    }
};  