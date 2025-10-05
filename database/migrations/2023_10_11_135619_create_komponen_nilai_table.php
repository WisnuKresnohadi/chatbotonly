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
        Schema::create('komponen_nilai', function (Blueprint $table) {
            $table->uuid('id_kompnilai')->primary();
            $table->uuid('id_jenismagang');
            $table->string('namakomponen', 255);
            $table->string('tipe', 255);
            $table->integer('bobot');
            $table->string('scoredby', 255);
            $table->boolean('status')->default(true);
            $table->integer('total_bobot');
            $table->foreign('id_jenismagang')->references('id_jenismagang')->on('jenis_magang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komponen_nilai');
    }
};
