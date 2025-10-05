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
        if (Schema::hasColumn('jenis_magang', 'id_year_akademik')) {
            Schema::table('jenis_magang', function (Blueprint $table) {
                $table->dropForeign('jenis_magang_id_year_akademik_foreign');
                $table->dropColumn('id_year_akademik');
            });
        } else {
            Schema::table('jenis_magang', function (Blueprint $table) {
                $table->uuid('id_year_akademik')->nullable();
                $table->foreign('id_year_akademik')->references('id_year_akademik')->on('tahun_akademik');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('jenis_magang', 'id_year_akademik')) {
            Schema::table('jenis_magang', function (Blueprint $table) {
                $table->dropForeign('jenis_magang_id_year_akademik_foreign');
                $table->dropColumn('id_year_akademik');
            });
        }
    }
};
