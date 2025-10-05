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
        Schema::create('status_seleksi', function (Blueprint $table) {
            $table->uuid('id_status_seleksi')->primary();
            $table->uuid('id_pendaftaran');
            $table->boolean('status_seleksi')->default(false);
            $table->date('tgl_seleksi');
            $table->time('waktu_seleksi');
            $table->foreign('id_pendaftaran')->references('id_pendaftaran')->on('pendaftaran_magang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_seleksi');
    }
};
