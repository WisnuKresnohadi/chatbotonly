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
        Schema::create('logbook_day', function (Blueprint $table) {
            $table->uuid('id_logbook_day')->primary();
            $table->uuid('id_logbook_week');
            $table->string('activity', 255);
            $table->integer('emoticon');
            $table->foreign('id_logbook_week')->references('id_logbook_week')->on('logbook_week');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logbook_day');
    }
};
