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
        Schema::create('experience', function (Blueprint $table) {
            $table->uuid('id_experience')->primary();
            $table->string('nim', 255);
            $table->string('posisi', 255);
            $table->string('jenis', 255);
            $table->string('name_intitutions', 255);
            $table->date('startdate');
            $table->date('enddate');
            $table->string('deskripsi', 255);
            $table->foreign('nim')->references('nim')->on('mahasiswa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experience');
    }
};
