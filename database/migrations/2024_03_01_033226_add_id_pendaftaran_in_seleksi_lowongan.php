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
        if (Schema::hasColumn('seleksi_lowongan', 'id_pendaftaran')) {
            Schema::table('seleksi_lowongan', function (Blueprint $table) {
                $table->dropForeign('seleksi_lowongan_id_pendaftaran_foreign');
                $table->dropColumn('id_pendaftaran');
            });
        } else {
            Schema::table('seleksi_lowongan', function (Blueprint $table) {
                $table->uuid('id_pendaftaran')->nullable();
                $table->foreign('id_pendaftaran')->references('id_pendaftaran')->on('pendaftaran_magang');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('seleksi_lowongan', 'id_pendaftaran')) {
            Schema::table('seleksi_lowongan', function (Blueprint $table) {
                $table->dropForeign('seleksi_lowongan_id_pendaftaran_foreign');
                $table->dropColumn('id_pendaftaran');
            });
        }
    }
};
