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
        Schema::create('mhs_mandiri', function (Blueprint $table) {
            $table->uuid('id_mhsmandiri')->primary();
            $table->uuid('id_pengajuan');
            $table->string('nim', 255);
            $table->dateTime('startdate');
            $table->dateTime('enddate');
            $table->string('bukti_doc', 255);
            $table->boolean('status');
            $table->foreign('id_pengajuan')->references('id_pengajuan')->on('pengajuan_mandiri');
            $table->foreign('nim')->references('nim')->on('mahasiswa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mhs_mandiri');
    }
};
