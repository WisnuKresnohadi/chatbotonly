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
        Schema::create('pegawai_industri', function (Blueprint $table) {
            $table->uuid('id_peg_industri')->primary();
            $table->uuid('id_industri');
            $table->string('namapeg', 255);
            $table->string('nohppeg', 255);
            $table->string('emailpeg', 255);
            $table->string('jabatan', 255);
            $table->string('unit', 255);
            $table->boolean('statuspeg')->default(true);
            $table->foreign('id_industri')->references('id_industri')->on('industri');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai_industri');
    }
};
