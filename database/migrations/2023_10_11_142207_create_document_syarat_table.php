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
        Schema::create('document_syarat', function (Blueprint $table) {
            $table->uuid('id_document')->primary();
            $table->uuid('id_jenismagang');
            $table->string('namadocument', 255);
            $table->boolean('status')->default(true);
            $table->foreign('id_jenismagang')->references('id_jenismagang')->on('jenis_magang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_syarat');
    }
};
