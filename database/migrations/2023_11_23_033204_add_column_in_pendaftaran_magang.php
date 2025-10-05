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
        if (Schema::hasColumn('pendaftaran_magang', 'tanggaldaftar')) {
            Schema::table('pendaftaran_magang', function (Blueprint $table) {
                $table->dropColumn('tanggaldaftar');
            });
        } else if (Schema::hasColumn('pendaftaran_magang', 'approvetime')) {
            Schema::table('pendaftaran_magang', function (Blueprint $table) {
                $table->dropColumn('approvetime');
            });
        } else if (Schema::hasColumn('pendaftaran_magang', 'approved_by')) {
            Schema::table('pendaftaran_magang', function (Blueprint $table) {
                $table->dropColumn('approved_by');
            });
        }
        Schema::table('pendaftaran_magang', function (Blueprint $table) {
            $table->date('tanggaldaftar')->nullable();
            $table->timestamp('approvetime')->nullable();
            $table->string('approved_by', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('pendaftaran_magang', 'tanggaldaftar')) {
            Schema::table('pendaftaran_magang', function (Blueprint $table) {
                $table->dropColumn('tanggaldaftar');
            });
        } else if (Schema::hasColumn('pendaftaran_magang', 'approvetime')) {
            Schema::table('pendaftaran_magang', function (Blueprint $table) {
                $table->dropColumn('approvetime');
            });
        } else if (Schema::hasColumn('pendaftaran_magang', 'approved_by')) {
            Schema::table('pendaftaran_magang', function (Blueprint $table) {
                $table->dropColumn('approved_by');
            });
        }
    }
};
