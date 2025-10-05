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
        if (!Schema::hasColumn('dosen', 'status_dosen')) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            Schema::table('mhs_magang', function (Blueprint $table) {
                $table->dropForeign(['nip']);
                $table->dropColumn("nip");
            });

            Schema::table('mhs_mandiri', function (Blueprint $table) {
                $table->dropForeign(['nip']);
                $table->dropColumn("nip");
            });

            Schema::table('dosen', function (Blueprint $table) {
                $table->string('nip')->change();
                $table->uuid('id_prodi')->nullable(true)->change();
                $table->string('nohpdosen', 15)->nullable()->change();
                $table->char('kode_dosen', 5)->nullable()->change();
                $table->string(column: 'status_dosen')->nullable();
                $table->timestamps();
            });

            Schema::table('mhs_magang', function (Blueprint $table) {
                $table->string('nip');
                $table->foreign('nip')->references('nip')->on('dosen');
            });

            Schema::table('mhs_mandiri', function (Blueprint $table) {
                $table->string('nip');
                $table->foreign('nip')->references('nip')->on('dosen');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dosen', function (Blueprint $table) {});
    }
};
