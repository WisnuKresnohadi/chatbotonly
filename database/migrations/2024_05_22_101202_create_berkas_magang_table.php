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
        Schema::create('berkas_magang', function (Blueprint $table) {
            $table->uuid('id_berkas_magang')->primary();
            $table->string('nama_berkas', 255);
            $table->text('template')->nullable();
            $table->boolean('status_upload')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berkas_magang');
    }
};
