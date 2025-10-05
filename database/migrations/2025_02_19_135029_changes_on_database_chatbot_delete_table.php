<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if the foreign key exists before trying to drop it
        Schema::table('hasil_wawancara', function (Blueprint $table) {
            // Get foreign keys of the table
            $foreignKeys = DB::select("
                SELECT CONSTRAINT_NAME
                FROM information_schema.KEY_COLUMN_USAGE
                WHERE TABLE_NAME = 'hasil_wawancara'
                AND COLUMN_NAME = 'id_wawancara'
            ");

            if (!empty($foreignKeys)) {
                $foreignKeyName = $foreignKeys[0]->CONSTRAINT_NAME;
                $table->dropForeign($foreignKeyName);
            }
        });

        // Drop the wawancara_magang table safely
        Schema::dropIfExists('wawancara_magang');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate the wawancara_magang table
        Schema::create('wawancara_magang', function (Blueprint $table) {
            $table->integer('id_wawancara', true);
            $table->char('id_lowongan', 36)->index();
            $table->json('list_kriteria_softskill');

            // Re-add the foreign key
            $table->foreign('id_lowongan')->references('id_lowongan')->on('lowongan_magang')->onDelete('cascade')->onUpdate('cascade');
        });

        // Re-add foreign key in hasil_wawancara
        Schema::table('hasil_wawancara', function (Blueprint $table) {
            $table->foreign('id_wawancara')->references('id_wawancara')->on('wawancara_magang')->onDelete('cascade')->onUpdate('cascade');
        });
    }
};
