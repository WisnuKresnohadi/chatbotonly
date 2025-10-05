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
        if (Schema::hasColumn('status_seleksi', 'tgl_seleksi')) {
            Schema::table('status_seleksi', function (Blueprint $table) {
                $table->dropColumn('tgl_seleksi');
            });
        }
        if (Schema::hasColumn('status_seleksi', 'waktu_seleksi')) {
            Schema::table('status_seleksi', function (Blueprint $table) {
                $table->dropColumn('waktu_seleksi');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('status_seleksi', function (Blueprint $table) {
            //
        });
    }
};
