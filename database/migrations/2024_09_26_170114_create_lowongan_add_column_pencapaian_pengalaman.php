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
        Schema::table('lowongan_magang', function (Blueprint $table) {
            $table->dropColumn('intern_position');
        });

        Schema::table('lowongan_magang', function (Blueprint $table) {
            $table->uuid('intern_position')->after('created_at')->nullable();
            $table->string('pencapaian')->nullable()->after('keterampilan');
            $table->string('pengalaman')->nullable()->after('pencapaian');

            $table->foreign('intern_position')->references('id_bidang_pekerjaan_industri')->on('bidang_pekerjaan_industri');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lowongan_magang', function (Blueprint $table) {
            $table->dropForeign(['intern_position']);
            $table->dropColumn('intern_position');
        });

        Schema::table('lowongan_magang', function (Blueprint $table) {
            $table->string('intern_position', 255)->after('created_at');
            $table->dropColumn('pencapaian');
            $table->dropColumn('pengalaman');
        });
    }
};
