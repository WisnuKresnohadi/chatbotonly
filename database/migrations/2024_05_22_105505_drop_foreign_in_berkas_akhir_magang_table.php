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
        if (Schema::hasColumn('berkas_akhir_magang', 'id_lap_akhir')) {
            Schema::table('berkas_akhir_magang', function (Blueprint $table) {
                $table->dropForeign('berkas_akhir_magang_id_lap_akhir_foreign');
                $table->dropColumn('id_lap_akhir');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('berkas_akhir_magang', 'id_lap_akhir')) {
            Schema::table('berkas_akhir_magang', function (Blueprint $table) {
                $table->dropForeign('berkas_akhir_magang_id_lap_akhir');
                $table->dropColumn('id_lap_akhir');
            });
        }
    }
};
