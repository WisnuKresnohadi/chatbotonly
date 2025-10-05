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
        Schema::create('intern_confirm', function (Blueprint $table) {
            $table->uuid('id_intern_confirm')->primary();
            $table->uuid('id_mhsmagang');
            $table->date('start_date');
            $table->date('end_date');
            $table->foreign('id_mhsmagang')->references('id_mhsmagang')->on('mhs_magang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intern_confirm');
    }
};
