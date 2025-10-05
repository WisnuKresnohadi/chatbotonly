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
        Schema::table('hasil_wawancara', function (Blueprint $table) {
            $table->dropForeign(['id_wawancara']);
            $table->dropColumn('id_wawancara');

            $table->char('id_pendaftaran', 36)->index()->after('nim');

            $table->foreign('id_pendaftaran')->references('id_pendaftaran')->on('pendaftaran_magang')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hasil_wawancara', function (Blueprint $table) {
            $table->dropForeign(['id_pendaftaran']);
            $table->dropColumn('id_pendaftaran');

            $table->integer('id_wawancara')->index()->after('nim');

            $table->foreign('id_wawancara')->references('id_wawancara')->on('wawancara_magang')->onDelete('cascade')->onUpdate('cascade');
        });
    }
};
