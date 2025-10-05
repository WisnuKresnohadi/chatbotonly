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
        if (Schema::hasColumn('lowongan_magang', 'id_lokasi') && Schema::hasColumn('lowongan_magang', 'paid')) {
            if (Schema::hasColumn('lowongan_magang', 'id_lokasi') && Schema::hasColumn('lowongan_magang', 'paid')) {
                Schema::table('lowongan_magang', function (Blueprint $table) {
                    $table->dropForeign('lowongan_magang_id_lokasi_foreign');
                    $table->dropColumn('id_lokasi');
                    $table->dropColumn('paid');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('lowongan_magang', 'id_lokasi') && Schema::hasColumn('lowongan_magang', 'paid')) {
            Schema::table('lowongan_magang', function (Blueprint $table) {
                $table->dropForeign('lowongan_magang_id_lokasi_foreign');
                $table->dropColumn('id_lokasi');
                $table->dropColumn('paid');
            });
        }
    }
};
