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
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->integer('eprt');
            $table->decimal('ipk', 3,2);
            $table->integer('tak');
            $table->string('sosmed',255)->nullable();
            $table->string('url_sosmed', 255)->nullable();
            $table->string('lok_magang', 255)->nullable();
            $table->string('skills', 255)->nullable();
            $table->string('bahasa', 255)->nullable();
            $table->string('tunggakan_bpp', 255);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            Schema::dropIfExists('mahasiswa', [
                'eprt',
                'ipk',
                'tak',
                'sosmed',
                'url_sosmed',
                'lok_magang',
                'skills',
                'bahasa',
                'tunggakan_bpp'
            ]); 
        });
    }
};
