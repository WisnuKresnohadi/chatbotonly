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
        if (Schema::hasColumn('seleksi_lowongan', 'tahapan_seleksi')) {
            Schema::table('seleksi_lowongan', function (Blueprint $table) {
                $table->dropColumn('tahapan_seleksi');
            });
        } else {
            Schema::table('seleksi_lowongan', function (Blueprint $table) {
                $table->string('tahapan_seleksi', 255)->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('seleksi_lowongan', 'tahapan_seleksi')) {
            Schema::table('seleksi_lowongan', function (Blueprint $table) {
                $table->dropColumn('tahapan_seleksi');
            });
        }
    }
};
