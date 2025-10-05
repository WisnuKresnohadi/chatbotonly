<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pendaftaran_magang', function (Blueprint $table) {
            $table->dropColumn('status_seleksi');
            $table->dropColumn('current_step');
        });

        Schema::table('pendaftaran_magang', function (Blueprint $table) {
            $table->enum('current_step', [
                'pending', 'approved_by_doswal', 'rejected_by_doswal', 
                'approved_by_kaprodi', 'rejected_by_kaprodi', 'seleksi_tahap_1', 'approved_seleksi_tahap_1', 
                'rejected_seleksi_tahap_1', 'approved_seleksi_tahap_2', 'rejected_seleksi_tahap_2', 
                'approved_seleksi_tahap_3', 'rejected_seleksi_tahap_3', 'approved_penawaran', 'rejected_penawaran'
            ])->default('pending');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftaran_magang', function (Blueprint $table) {
            $table->dropColumn('current_step');
        });
        Schema::table('pendaftaran_magang', function (Blueprint $table) {
            $table->enum('current_step', ['pending', 'approved_by_doswal', 'rejected_by_doswal', 
            'approved_by_kaprodi', 'rejected_by_kaprodi', 'screening', 'seleksi_tahap_1', 'seleksi_tahap_2', 'seleksi_tahap_3', 'penawaran', 'approved_by_company', 'rejected_by_company', 'approved_by_mahasiswa', 'rejected_by_mahasiswa'])->default('pending');

            $table->enum('status_seleksi', ['done', 'not_yet'])->nullable();
        });
    }
};
