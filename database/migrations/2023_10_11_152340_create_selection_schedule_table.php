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
        Schema::create('selection_schedule', function (Blueprint $table) {
            $table->uuid('id_schedule')->primary();
            $table->uuid('id_lowongan');
            $table->date('schedule_date');
            $table->string('status', 255);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('selection_schedule');
    }
};
