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
        if (Schema::hasColumn('pendaftaran_magang', 'status') && Schema::hasColumn('pendaftaran_magang', 'applicant_status')) {
            Schema::table('pendaftaran_magang', function (Blueprint $table) {
                $table->dropColumn('status');
                $table->dropColumn('applicant_status');
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
