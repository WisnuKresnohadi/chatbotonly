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
        Schema::dropIfExists('skills');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('skills', function (Blueprint $table) {
            $table->uuid('id_skills')->primary();
            $table->string('nim')->nullable();
            $table->foreign('nim')->references('nim')->on('mahasiswa');
            $table->string('skills')->nullable();
        });
    }
};
