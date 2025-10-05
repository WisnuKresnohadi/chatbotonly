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
        if (Schema::hasColumn('seleksi', 'id_lowongan')) {
            Schema::table('seleksi', function (Blueprint $table) {
                $table->dropColumn('id_lowongan');
            });
        } else {
            Schema::table('seleksi', function (Blueprint $table) {
                $table->uuid('id_lowongan');
                $table->foreign('id_lowongan')->references('id_lowongan')->on('lowongan_magang');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seleksi', function (Blueprint $table) {
            //
        });
    }
};
