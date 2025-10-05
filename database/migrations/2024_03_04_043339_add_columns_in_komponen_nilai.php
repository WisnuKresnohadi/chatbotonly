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
        if (
            Schema::hasColumn('komponen_nilai', 'id_year_akademik')
            && Schema::hasColumn('komponen_nilai', 'kategori')
            && Schema::hasColumn('komponen_nilai', 'deskripsi_penilaian')
            && Schema::hasColumn('komponen_nilai', 'aspek_penilaian')
            && Schema::hasColumn('komponen_nilai', 'scored_by')
            && Schema::hasColumn('komponen_nilai', 'nilai_max')
        ) {
            Schema::table('komponen_nilai', function (Blueprint $table) {
                $table->dropColumn('kategori');
                $table->dropColumn('aspek_penilaian');
                $table->dropColumn('deskripsi_penilaian');
                $table->dropColumn('scored_by');
                $table->dropColumn('nilai_max');
                $table->dropForeign('komponen_nilai_id_year_akademik_foreign');
                $table->dropColumn('id_year_akademik');
            });
        } else {
            Schema::table('komponen_nilai', function (Blueprint $table) {
                $table->uuid('id_year_akademik')->nullable();
                $table->integer('kategori')->nullable();
                $table->string('aspek_penilaian', 255)->nullable();
                $table->string('deskripsi_penilaian', 255)->nullable();
                $table->string('scored_by', 255)->nullable();
                $table->string('nilai_max', 100)->nullable();
                $table->foreign('id_year_akademik')->references('id_year_akademik')->on('tahun_akademik');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('komponen_nilai', function (Blueprint $table) {
            //
        });
    }
};
