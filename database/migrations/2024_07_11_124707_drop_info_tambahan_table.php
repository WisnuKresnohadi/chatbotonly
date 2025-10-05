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
        Schema::dropIfExists('info_tambahan');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('info_tambahan', function (Blueprint $table) {
            $table->uuid('id_infotab')->primary();
            $table->string('nim')->nullable();
            $table->foreign('nim')->references('nim')->on('mahasiswa');
            $table->string('lok_kerja')->nullable();
            $table->uuid('id_bahasa')->nullable();
            $table->foreign('id_bahasa')->references('id_bahasa')->on('bahasa');
            $table->text('url_sosmed')->nullable();
            $table->string('sosmed')->nullable();
        });
    }
};
