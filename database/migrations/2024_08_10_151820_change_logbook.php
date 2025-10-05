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
        Schema::table('logbook', function (Blueprint $table) {
            $table->uuid('id_pendaftaran')->nullable();
            $table->foreign('id_pendaftaran')->references('id_pendaftaran')->on('pendaftaran_magang');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('logbook', function (Blueprint $table) {
            $table->dropForeign(['id_pendaftaran']);
            $table->dropColumn('id_pendaftaran');

            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
        });
    }
};
