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
        Schema::table('lowongan_magang', function (Blueprint $table) {
            $table->date('mulai_magang')->nullable();
            $table->date('selesai_magang')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lowongan_magang', function (Blueprint $table) {
            $table->dropColumn(['mulai_magang', 'selesai_magang']);
        });
    }
};
