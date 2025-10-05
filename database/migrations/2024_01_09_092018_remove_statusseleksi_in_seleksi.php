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
        if (Schema::hasColumn('seleksi', 'id_pendaftaran')) {
            Schema::table('seleksi', function (Blueprint $table) {
                $table->dropColumn('id_pendaftaran');
            });
        }
        if (Schema::hasColumn('seleksi', 'tglseleksi')) {
            Schema::table('seleksi', function (Blueprint $table) {
                $table->dropColumn('tglseleksi');
            });
        }
        if (Schema::hasColumn('seleksi', 'jamseleksi')) {
            Schema::table('seleksi', function (Blueprint $table) {
                $table->dropColumn('jamseleksi');
            });
        }
        if (Schema::hasColumn('seleksi', 'statusseleksi')) {
            Schema::table('seleksi', function (Blueprint $table) {
                $table->dropColumn('statusseleksi');
            });
        }
        if (Schema::hasColumn('seleksi', 'pelaksanaan')) {
            Schema::table('seleksi', function (Blueprint $table) {
                $table->dropColumn('pelaksanaan');
            });
        }
        if (Schema::hasColumn('seleksi', 'detail')) {
            Schema::table('seleksi', function (Blueprint $table) {
                $table->dropColumn('detail');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seleksi', function (Blueprint $table) {
            //
        });
    }
};
