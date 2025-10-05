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
        if (Schema::hasIndex('mhs_mandiri', 'mhs_mandiri_nip_foreign')) {
            Schema::table('mhs_mandiri', function (Blueprint $table) {
                $table->dropForeign(['nip']);
            });
        }

        Schema::table('mhs_mandiri', function (Blueprint $table) {
            $table->foreign('nip')->references('nip')->on('dosen')->onUpdate('cascade');
        });

        Schema::table('mhs_magang', function (Blueprint $table) {
            $table->dropForeign(['nip']);
        });

        Schema::table('mhs_magang', function (Blueprint $table) {
            $table->foreign('nip')->references('nip')->on('dosen')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mhs_magang', function (Blueprint $table) {
            $table->dropForeign(['nip']);
        });
        Schema::table('mhs_magang', function (Blueprint $table) {
            $table->foreign('nip')->references('nip')->on('dosen')->onUpdate('restrict');
        });
        Schema::table('mhs_mandiri', function (Blueprint $table) {
            $table->dropForeign(['nip']);
        });
        Schema::table('mhs_mandiri', function (Blueprint $table) {
            $table->foreign('nip')->references('nip')->on('dosen')->onUpdate('restrict');
        });
    }
};
