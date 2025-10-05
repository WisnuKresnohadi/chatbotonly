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
        Schema::table('experience', function (Blueprint $table) {
            $table->string('nama', 255)->nullable();            
            $table->string('prestasi', 255)->nullable();
            $table->string('kategori', 255)->nullable();
            $table->string('posisi', 255)->nullable()->change();
            $table->string('name_intitutions', 255)->nullable()->change();
            $table->string('jenis', 255)->nullable()->change();
            $table->string('deskripsi', 255)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('experience', function (Blueprint $table) {
            $table->dropColumn('nama');
            $table->dropColumn('kategori');
            $table->dropColumn('prestasi');

            // $table->string('posisi', 255)->nullable(false)->change();
            // $table->string('deskripsi', 255)->nullable(false)->change();
            // $table->string('`name_intitutions`', 255)->nullable(false)->change();
            // $table->string('jenis', 255)->nullable(false)->change();
        });
    }
};
