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
        Schema::create('nilai_pemblap', function (Blueprint $table) {
            $table->uuid('id_nilai')->primary();
            $table->uuid('id_mhsmagang');
            $table->uuid('id_kompnilai');
            $table->integer('nilai');
            $table->string('oleh', 255);
            $table->date('dateinputnilai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_pemblap');
    }
};
