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
        Schema::create('lowongan_magang', function (Blueprint $table) {
            $table->uuid('id_lowongan')->primary();
            $table->uuid('id_industri');
            $table->uuid('id_year_akademik');
            $table->string('created_by');
            $table->uuid('id_jenismagang');
            $table->timestamp('created_at');
            $table->string('intern_position', 255);
            $table->string('bidang', 255);
            $table->integer('durasimagang');
            $table->string('deskripsi', 255);
            $table->text('requirements');
            $table->uuid('id_lokasi');
            $table->integer('kuota');
            $table->text('benefitmagang');
            $table->date('startdate');
            $table->date('enddate');
            $table->string('tahapan_seleksi', 255);
            $table->date('date_confirm_closing');
            $table->boolean('pelaksanaan');
            $table->foreign('id_jenismagang')->references('id_jenismagang')->on('jenis_magang');
            $table->foreign('id_year_akademik')->references('id_year_akademik')->on('tahun_akademik');
            $table->foreign('id_industri')->references('id_industri')->on('industri');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lowongan_magang');
    }
};
