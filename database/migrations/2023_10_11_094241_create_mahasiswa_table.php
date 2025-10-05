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
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->integer('nim')->primary();
            $table->integer('angkatan');
            $table->uuid('id_prodi')->nullable();
            $table->uuid('id_univ')->nullable();
            $table->uuid('id_fakultas')->nullable();
            $table->string('namamhs', 255);
            $table->string('alamatmhs', 255);
            $table->string('emailmhs', 255);
            $table->string('nohpmhs', 15);
            $table->string('kelas', 255)->nullable();
            $table->boolean('status')->default(true);
            $table->foreign('id_prodi')->references('id_prodi')->on('program_studi');
            $table->foreign('id_univ')->references('id_univ')->on('universitas');
            $table->foreign('id_fakultas')->references('id_fakultas')->on('fakultas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswa');
    }
};
