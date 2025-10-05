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
        Schema::create('config_nilai_akhir', function (Blueprint $table) {
            $table->uuid('id_config_nilai_akhir')->primary();

            $table->uuid('id_prodi')->nullable();
            $table->foreign('id_prodi')->references('id_prodi')->on('program_studi');

            $table->double('nilai_pemb_lap')->nullable();
            $table->double('nilai_pemb_akademik')->nullable();

            $table->boolean('status')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('config_nilai_akhir');
    }
};
