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
        if (
            Schema::hasColumn('komponen_nilai', 'namakomponen')
            && Schema::hasColumn('komponen_nilai', 'tipe')
            && Schema::hasColumn('komponen_nilai', 'scoredby')
            && Schema::hasColumn('komponen_nilai', 'total_bobot')
        ) {
            Schema::table('komponen_nilai', function (Blueprint $table) {
                $table->dropColumn('namakomponen');
                $table->dropColumn('tipe');
                $table->dropColumn('scoredby');
                $table->dropColumn('total_bobot');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('komponen_nilai', function (Blueprint $table) {
            //
        });
    }
};
