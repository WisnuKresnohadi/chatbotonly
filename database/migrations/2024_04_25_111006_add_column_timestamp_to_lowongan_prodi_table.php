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
        Schema::table('lowongan_prodi', function (Blueprint $table) {
            $table->id('lowongan_prodi_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lowongan_prodi', function (Blueprint $table) {
            $table->dropColumn('lowongan_prodi_id');
            $table->dropTimestamps();
        });
    }
};
