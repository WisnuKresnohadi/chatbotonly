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
        Schema::table('pendaftaran_magang', function (Blueprint $table) {
            $table->string('skills')->nullable();
            $table->string('headliner')->nullable();
            $table->string('deskripsi_diri')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftaran_magang', function (Blueprint $table) {
            $table->dropColumn(['skills', 'headliner', 'deskripsi_diri']);
        });
    }
};
