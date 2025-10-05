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
        Schema::table('pendaftaran_magang', function (Blueprint $table) {
            $table->dropColumn('id_year_akademik');
            $table->dropColumn('approval');
            $table->dropColumn('approvetime');
            $table->dropColumn('approved_by');
            $table->dropColumn('portofolio');

            $table->json('history_approval')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftaran_magang', function (Blueprint $table) {
            $table->uuid('id_year_akademik')->nullable();
            $table->tinyInteger('approval')->nullable();
            $table->timestamp('approvetime')->nullable();
            $table->string('approved_by')->nullable();
            $table->string('portofolio')->nullable();

            $table->dropColumn('history_approval');
        });
    }
};
