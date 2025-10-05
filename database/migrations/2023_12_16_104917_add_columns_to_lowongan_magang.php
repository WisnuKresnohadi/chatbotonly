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
        if (Schema::hasColumn('lowongan_magang', 'jenjang')) {
            Schema::table('lowongan_magang', function (Blueprint $table) {
                $table->dropColumn('jenjang');
            });
        } else if (Schema::hasColumn('lowongan_magang', 'keilmuan')) {
            Schema::table('lowongan_magang', function (Blueprint $table) {
                $table->dropColumn('keilmuan');
            });
        } else if (Schema::hasColumn('lowongan_magang', 'keterampilan')) {
            Schema::table('lowongan_magang', function (Blueprint $table) {
                $table->dropColumn('keterampilan');
            });
        }

        Schema::table('lowongan_magang', function (Blueprint $table) {
            $table->string('jenjang', 255);
            $table->string('keilmuan', 255);
            $table->string('keterampilan', 255);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('lowongan_magang', 'jenjang')) {
            Schema::table('lowongan_magang', function (Blueprint $table) {
                $table->dropColumn('jenjang');
            });
        } else if (Schema::hasColumn('lowongan_magang', 'keilmuan')) {
            Schema::table('lowongan_magang', function (Blueprint $table) {
                $table->dropColumn('keilmuan');
            });
        } else if (Schema::hasColumn('lowongan_magang', 'keterampilan')) {
            Schema::table('lowongan_magang', function (Blueprint $table) {
                $table->dropColumn('keterampilan');
            });
        }
    }
};
