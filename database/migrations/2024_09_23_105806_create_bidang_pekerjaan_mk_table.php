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
        Schema::create('bidang_pekerjaan_mk', function (Blueprint $table) {
            $table->uuid('id_bidang_pekerjaan_mk')->primary();
            $table->tinyInteger('bobot');
            $table->uuid('id_bidang_pekerjaan_industri');            
            $table->string('kode_mk', 255);
            $table->foreign('id_bidang_pekerjaan_industri')->references('id_bidang_pekerjaan_industri')->on('bidang_pekerjaan_industri')->onDelete('cascade');;                        
            $table->foreign('kode_mk')->references('kode_mk')->on('mata_kuliah')->onDelete('cascade');                        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bidang_pekerjaan_mk');
    }
};
