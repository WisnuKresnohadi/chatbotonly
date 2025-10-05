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
        Schema::table('nilai_pemblap', function (Blueprint $table) {
            $table->uuid('id_mhsmagang')->nullable()->change();
            $table->uuid('id_kompnilai')->nullable()->change();
            $table->integer('nilai')->nullable()->change();
            $table->string('oleh')->nullable()->change();
            $table->date('dateinputnilai')->nullable()->change();

            $table->foreign('id_mhsmagang')->references('id_mhsmagang')->on('mhs_magang');
            $table->foreign('id_kompnilai')->references('id_kompnilai')->on('komponen_nilai');

            $table->string('aspek_penilaian')->nullable();
            $table->integer('nilai_max')->nullable();
            $table->longText('deskripsi_penilaian')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nilai_pemblap', function (Blueprint $table) {
            $table->uuid('id_mhsmagang')->nullable(false)->change();
            $table->uuid('id_kompnilai')->nullable(false)->change();
            $table->integer('nilai')->nullable(false)->change();
            $table->string('oleh')->nullable(false)->change();
            $table->date('dateinputnilai')->nullable(false)->change();

            $table->dropForeign(['id_mhsmagang']);
            $table->dropIndex('nilai_pemblap_id_mhsmagang_foreign');
            $table->dropForeign(['id_kompnilai']);
            $table->dropIndex('nilai_pemblap_id_kompnilai_foreign');

            $table->dropColumn(['aspek_penilaian', 'nilai_max', 'deskripsi_penilaian', 'created_at', 'updated_at']);
        });
    }
};
