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
        Schema::create('nilai_intern', function (Blueprint $table) {
            $table->uuid('id_nilai_intern')->primary();
            $table->uuid('id_nilai');
            $table->uuid('id_kompnilai');
            $table->integer('nilai');
            $table->string('deskripsi', 255);
            $table->uuid('id_mhsmagang');
            $table->string('created_by', 255);
            $table->integer('nilaiadjust');
            $table->date('tgladjust');
            $table->string('alasanadjust', 255);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_intern');
    }
};
