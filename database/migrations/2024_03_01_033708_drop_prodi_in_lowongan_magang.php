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
        if (Schema::hasColumn('lowongan_magang', 'fakultas') && Schema::hasColumn('lowongan_magang', 'prodi') && Schema::hasColumn('lowongan_magang', 'applicant_status')) {
            Schema::table('lowongan_magang', function (Blueprint $table) {
                $table->dropColumn('fakultas');
                $table->dropColumn('prodi');
                $table->dropColumn('applicant_status');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lowongan_magang', function (Blueprint $table) {
            //
        });
    }
};
