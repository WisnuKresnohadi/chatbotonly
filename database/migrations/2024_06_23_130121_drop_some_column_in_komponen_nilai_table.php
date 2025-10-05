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
        Schema::table('komponen_nilai', function (Blueprint $table) {
            $table->dropColumn('bobot');
            $table->dropColumn('kategori');

            $table->dropForeign('komponen_nilai_id_year_akademik_foreign');
            $table->dropColumn('id_year_akademik');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('komponen_nilai', function (Blueprint $table) {
            $table->integer('bobot')->default(0);
            $table->string('kategori', 255)->nullable();
            $table->uuid('id_year_akademik')->nullable();
            $table->foreign('id_year_akademik')->references('id_year_akademik')->on('tahun_akademik');
        });
    }
};
