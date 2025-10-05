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
        Schema::table('berkas_akhir_magang', function (Blueprint $table) {
            $table->uuid('id_berkas_magang')->nullable();
            $table->foreign('id_berkas_magang')->references('id_berkas_magang')->on('berkas_magang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('berkas_akhir_magang', function (Blueprint $table) {
            //
        });
    }
};
