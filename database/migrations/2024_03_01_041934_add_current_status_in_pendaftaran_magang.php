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
        if (Schema::hasColumn('pendaftaran_magang', 'current_step') && Schema::hasColumn('pendaftaran_magang', 'konfirmasi_status') && Schema::hasColumn('pendaftaran_magang', 'status_seleksi')) {
            Schema::table('pendaftaran_magang', function (Blueprint $table) {
                $table->dropColumn('current_step');
                $table->dropColumn('konfirmasi_status');
                $table->dropColumn('status_seleksi');
            });
        } else {
            Schema::table('pendaftaran_magang', function (Blueprint $table) {
                $table->string('current_step', 100)->nullable()->default('screening');
                $table->boolean('konfirmasi_status')->nullable();
                $table->boolean('status_seleksi')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftaran_magang', function (Blueprint $table) {
            //
        });
    }
};
