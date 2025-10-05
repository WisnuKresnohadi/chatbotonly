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
        Schema::create('universitas', function (Blueprint $table) {
            $table->uuid('id_univ')->primary();
            $table->string('namauniv', 255);
            $table->string('jalan', 255);
            $table->string('kota', 255);
            $table->string('telp', 15);
            $table->boolean('status')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('universitas');
    }
};
