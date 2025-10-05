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
        Schema::create('pengajuan_mandiri', function (Blueprint $table) {
            $table->uuid('id_pengajuan')->primary();
            $table->string('nim', 255);
            $table->string('nama_industri', 255);
            $table->string('email', 255);
            $table->integer('nohp');
            $table->string('alamat_industri', 255);
            $table->string('posisi_magang', 255);
            $table->dateTime('startdate');
            $table->dateTime('enddate');
            $table->date('tglpeng');
            $table->boolean('status');
            $table->foreign('nim')->references('nim')->on('mahasiswa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_mandiri');
    }
};
