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
        if (Schema::hasColumn('seleksi_lowongan', 'id_status_seleksi') && Schema::hasColumn('seleksi_lowongan', 'namatahap_seleksi')) {
            Schema::table('seleksi_lowongan', function (Blueprint $table) {
                $table->dropForeign('seleksi_lowongan_id_status_seleksi_foreign');
                $table->dropColumn('id_status_seleksi');
                $table->dropColumn('namatahap_seleksi');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('seleksi_lowongan', 'id_status_seleksi') && Schema::hasColumn('seleksi_lowongan', 'namatahap_seleksi')) {
            Schema::table('seleksi_lowongan', function (Blueprint $table) {
                $table->dropForeign('seleksi_lowongan_id_status_seleksi_foreign');
                $table->dropColumn('id_status_seleksi');
                $table->dropColumn('namatahap_seleksi');
            });
        }
    }
};
