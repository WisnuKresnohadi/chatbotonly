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
        if (Schema::hasColumn('seleksi_lowongan', 'id_lowongan')) {
            Schema::table('seleksi_lowongan', function (Blueprint $table) {
                $table->dropForeign('seleksi_lowongan_id_lowongan_foreign');
                $table->dropColumn('id_lowongan');
            });
        } else {
            Schema::table('seleksi_lowongan', function (Blueprint $table) {
                $table->uuid('id_lowongan')->nullable();
                $table->foreign('id_lowongan')->references('id_lowongan')->on('lowongan_magang');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('seleksi_lowongan', 'id_lowongan')) {
            Schema::table('seleksi_lowongan', function (Blueprint $table) {
                $table->dropForeign('seleksi_lowongan_id_lowongan_foreign');
                $table->dropColumn('id_lowongan');
            });
        }
    }
};
