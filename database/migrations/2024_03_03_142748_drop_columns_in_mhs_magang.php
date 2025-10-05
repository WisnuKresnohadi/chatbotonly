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
        if (Schema::hasColumn('mhs_magang', 'nim') && Schema::hasColumn('mhs_magang', 'id_pemblap') && Schema::hasColumn('mhs_magang', 'indeks_nilai_akhir_magang')) {
            Schema::table('mhs_magang', function (Blueprint $table) {
                $table->dropColumn('nim');
                $table->dropColumn('id_pemblap');
                $table->dropColumn('indeks_nilai_akhir_magang');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mhs_magang', function (Blueprint $table) {
            //
        });
    }
};
