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
        if (Schema::hasColumn('mhs_magang', 'nilai_adjust') && Schema::hasColumn('mhs_magang', 'alasan_adjust')) {
            Schema::table('mhs_magang', function (Blueprint $table) {
                $table->dropColumn('nilai_adjust');
                $table->dropColumn('alasan_adjust');
            });
        } else {
            Schema::table('mhs_magang', function (Blueprint $table) {
                $table->integer('nilai_adjust')->nullable();
                $table->text('alasan_adjust')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('mhs_magang', 'nilai_adjust') && Schema::hasColumn('mhs_magang', 'alasan_adjust')) {
            Schema::table('mhs_magang', function (Blueprint $table) {
                $table->dropColumn('nilai_adjust');
                $table->dropColumn('alasan_adjust');
            });
        }
    }
};
