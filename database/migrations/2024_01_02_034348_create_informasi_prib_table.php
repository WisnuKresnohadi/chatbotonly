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
        Schema::create('informasi_prib', function (Blueprint $table) {
            $table->uuid('id_infoprib')->primary();
            $table->string('nim');
            $table->integer('ipk')->nullable();
            $table->integer('eprt')->nullable();
            $table->integer('TAK')->nullable();
            $table->date('tgl_lahir');
            $table->string('headliner', 255);
            $table->string('deskripsi_diri', 255);
            $table->foreign('nim')->references('nim')->on('mahasiswa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informasi_prib');
    }
};
