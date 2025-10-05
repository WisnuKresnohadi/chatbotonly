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
        Schema::create('mata_kuliah', function (Blueprint $table) {
            $table->string('kode_mk', 255)->primary();
            $table->uuid('id_univ')->nullable();
            $table->uuid('id_fakultas')->nullable();
            $table->uuid('id_prodi');
            $table->string('namamk', 255); 
            $table->tinyInteger('sks')->unsigned();
            $table->boolean('status')->default(true);
            $table->foreign('id_univ')->references('id_univ')->on('universitas');
            $table->foreign('id_fakultas')->references('id_fakultas')->on('fakultas');
            $table->foreign('id_prodi')->references('id_prodi')->on('program_studi');            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mata_kuliah');
    }
};
