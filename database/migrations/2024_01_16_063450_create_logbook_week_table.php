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
        Schema::create('logbook_week', function (Blueprint $table) {
            $table->uuid('id_logbook_week')->primary();
            $table->uuid('id_logbook');
            $table->string('Week', 255);
            $table->string('approve_lap', 255)->nullable();
            $table->string('approve_akademik', 255)->nullable();
            $table->date('date_approvelap')->nullable();
            $table->date('date_approve_akadmeik')->nullable();
            $table->boolean('status')->nullable()->default(false);
            $table->foreign('id_logbook')->references('id_logbook')->on('logbook');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logbook_week');
    }
};
