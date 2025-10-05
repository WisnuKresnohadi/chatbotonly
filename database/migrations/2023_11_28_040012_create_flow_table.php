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
        Schema::create('flow', function (Blueprint $table) {
            $table->integer('id_flow')->primary();
            $table->integer('prev')->nullable();
            $table->integer('next')->nullable();
            $table->foreign('next')->references('id_status')->on('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flow');
    }
};
