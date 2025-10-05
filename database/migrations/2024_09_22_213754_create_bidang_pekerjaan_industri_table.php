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
        Schema::create('bidang_pekerjaan_industri', function (Blueprint $table) {
            $table->uuid('id_bidang_pekerjaan_industri')->primary();
            $table->uuid('id_industri');
            $table->string(column: 'nama');
            $table->text('deskripsi');            
            $table->foreign('id_industri')->references('id_industri')->on('industri')->onDelete('cascade');  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bidang_pekerjaan_industri');
    }
};
