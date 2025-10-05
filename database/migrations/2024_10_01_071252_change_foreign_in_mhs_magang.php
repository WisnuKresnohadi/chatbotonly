<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // dd(Schema::hasIndex('mhs_magang', 'mhs_magang_nip_foreign'));
        if (Schema::hasIndex('mhs_magang', 'mhs_magang_nip_foreign')) {
            Schema::table('mhs_magang', function (Blueprint $table) {
                $table->dropForeign(['nip']);
            });
        }
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
            $table->foreign('nip')->references('nip')->on('dosen');
        });
    }
};
