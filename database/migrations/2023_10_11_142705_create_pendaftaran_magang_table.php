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
        Schema::create('pendaftaran_magang', function (Blueprint $table) {
            $table->uuid('id_pendaftaran')->primary();
            $table->uuid('id_lowongan');
            $table->date('tanggaldaftar');
            $table->integer('nim');
            $table->string('applicant_status', 255);
            $table->uuid('id_year_akademik');
            $table->integer('approval');
            $table->timestamp('approvetime');
            $table->boolean('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_magang');
    }
};
