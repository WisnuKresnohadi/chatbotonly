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
        if (Schema::hasColumn('berkas_magang', 'id_jenismagang')) {
            Schema::table('berkas_magang', function (Blueprint $table) {
                $table->dropForeign('berkas_magang_id_jenismagang_foreign');
                $table->dropColumn('id_jenismagang');
            });
        } else {
            Schema::table('berkas_magang', function (Blueprint $table) {
                $table->uuid('id_jenismagang')->nullable();
                $table->foreign('id_jenismagang')->references('id_jenismagang')->on('jenis_magang');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('berkas_magang', 'id_jenismagang')) {
            Schema::table('berkas_magang', function (Blueprint $table) {
                $table->dropForeign('berkas_magang_id_jenismagang_foreign');
                $table->dropColumn('id_jenismagang');
            });
        }
    }
};
