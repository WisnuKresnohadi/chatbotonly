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
        Schema::create('program_studi', function (Blueprint $table) {
            $table->uuid('id_prodi')->primary();
            $table->uuid('id_fakultas');
            $table->string('namaprodi', 255);
            $table->boolean('status')->default(true);
            $table->uuid('id_univ');
            $table->foreign('id_univ')->references('id_univ')->on('universitas');
            $table->foreign('id_fakultas')->references('id_fakultas')->on('fakultas');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_studi');
    }
};
