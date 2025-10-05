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
            Schema::hasColumn('mhs_magang', 'id_pengajuan')
            && Schema::hasColumn('mhs_magang', 'jenis_magang')
            && Schema::hasColumn('mhs_magang', 'id_pbb')
            && Schema::hasColumn('mhs_magang', 'indeks_nilai_akhir')
            && Schema::hasColumn('mhs_magang', 'id_peg_industri')
            && Schema::hasColumn('mhs_magang', 'nilai_lap')
            && Schema::hasColumn('mhs_magang', 'nilai_akademik')
            && Schema::hasColumn('mhs_magang', 'startdate_magang')
            && Schema::hasColumn('mhs_magang', 'enddate_magang')
        ) {
            Schema::table('mhs_magang', function (Blueprint $table) {
                $table->dropForeign('mhs_magang_id_pengajuan_foreign');
                $table->dropForeign('mhs_magang_id_pbb_foreign');
                $table->dropForeign('mhs_magang_id_peg_industri_foreign');
                $table->dropColumn('id_pengajuan');
                $table->dropColumn('id_peg_industri');
                $table->dropColumn('id_pbb');
                $table->dropColumn('jenis_magang');
                $table->dropColumn('indeks_nilai_akhir');
                $table->dropColumn('nilai_lap');
                $table->dropColumn('nilai_akademik');
                $table->dropColumn('startdate_magang');
                $table->dropColumn('enddate_magang');
            });
        } else {
            Schema::table('mhs_magang', function (Blueprint $table) {
                $table->uuid('id_pengajuan')->nullable();
                $table->uuid('id_pbb')->nullable();
                $table->uuid('id_peg_industri')->nullable();
                $table->boolean('jenis_magang')->nullable();
                $table->string('indeks_nilai_akhir', 100)->nullable();
                $table->integer('nilai_lap')->nullable();
                $table->integer('nilai_akademik')->nullable();
                $table->dateTime('startdate_magang')->nullable();
                $table->dateTime('enddate_magang')->nullable();
                $table->foreign('id_pengajuan')->references('id_pengajuan')->on('pengajuan_mandiri');
                $table->foreign('id_pbb')->references('id_pbb')->on('pbb_mandiri');
                $table->foreign('id_peg_industri')->references('id_peg_industri')->on('pegawai_industri');
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
