<?php

use Illuminate\Support\Facades\DB;
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
        DB::statement("ALTER TABLE pendaftaran_magang MODIFY COLUMN current_step enum('pending','approved_by_doswal','rejected_by_doswal','approved_by_kaprodi','rejected_by_kaprodi','approved_by_lkm','rejected_by_lkm','seleksi_tahap_1','rejected_screening','approved_seleksi_tahap_1','rejected_seleksi_tahap_1','approved_seleksi_tahap_2','rejected_seleksi_tahap_2','approved_seleksi_tahap_3','rejected_seleksi_tahap_3','approved_penawaran','rejected_penawaran','diberhentikan_magang','mengundurkan_diri') DEFAULT 'pending' NOT NULL;");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE pendaftaran_magang MODIFY COLUMN current_step enum('pending','approved_by_doswal','rejected_by_doswal','approved_by_kaprodi','rejected_by_kaprodi','approved_by_lkm','rejected_by_lkm','seleksi_tahap_1','rejected_screening','approved_seleksi_tahap_1','rejected_seleksi_tahap_1','approved_seleksi_tahap_2','rejected_seleksi_tahap_2','approved_seleksi_tahap_3','rejected_seleksi_tahap_3','approved_penawaran','rejected_penawaran','diberhentikan_magang') DEFAULT 'pending' NOT NULL;");
    }
};
