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
        Schema::create('logbook', function (Blueprint $table) {
            $table->uuid('id_logbook')->primary();
            $table->uuid('id_mhsmagang');
            $table->uuid('id_intern_confirm');
            $table->foreign('id_mhsmagang')->references('id_mhsmagang')->on('mhs_magang');
            $table->foreign('id_intern_confirm')->references('id_intern_confirm')->on('intern_confirm');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logbook');
    }
};
