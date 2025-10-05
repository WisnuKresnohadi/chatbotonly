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
            $table->dropForeign('lowongan_magang_id_fakultas_foreign');
            $table->dropForeign('lowongan_magang_id_prodi_foreign');
            $table->dropColumn('id_fakultas');
            $table->dropColumn('id_prodi');

            $table->longText('jenjang')->nullable()->change();
            $table->double('nominal_salary', 15, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lowongan_magang', function (Blueprint $table) {
            $table->uuid('id_fakultas')->nullable();
            $table->uuid('id_prodi')->nullable();
            $table->foreign('id_fakultas')->references('id_fakultas')->on('fakultas');
            $table->foreign('id_prodi')->references('id_prodi')->on('program_studi');

            $table->string('jenjang')->nullable()->change();
            $table->string('nominal_salary')->nullable()->change();
        });
    }
};
