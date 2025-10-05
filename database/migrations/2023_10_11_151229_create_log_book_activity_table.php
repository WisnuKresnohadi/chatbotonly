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
        Schema::create('log_book_activity', function (Blueprint $table) {
            $table->uuid('id_log')->primary();
            $table->uuid('id_mhsmagang');
            $table->date('date');
            $table->string('activity', 255);
            $table->string('documentation', 255);
            $table->integer('approvelap');
            $table->date('date_approvelap');
            $table->integer('approve_akademik');
            $table->date('date_approve_akademik');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_book_activity');
    }
};
