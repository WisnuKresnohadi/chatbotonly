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
        if (Schema::hasColumn('pendaftaran_magang', 'bukti_doc') && Schema::hasColumn('pendaftaran_magang', 'reason_aplicant') && Schema::hasColumn('pendaftaran_magang', 'portofolio')) {
            Schema::table('pendaftaran_magang', function (Blueprint $table) {
                $table->dropColumn('bukti_doc');
                $table->dropColumn('reason_aplicant');
                $table->dropColumn('portofolio');
            });
        } else {
            Schema::table('pendaftaran_magang', function (Blueprint $table) {
                $table->string('bukti_doc', 255)->nullable();
                $table->text('reason_aplicant')->nullable();
                $table->string('portofolio', 255)->nullable();
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
