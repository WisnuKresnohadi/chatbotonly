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
        Schema::table('mhs_magang', function (Blueprint $table) {
            $table->double('nilai_akhir_magang')->nullable()->change();
            $table->string('indeks_nilai_akhir', 5)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mhs_magang', function (Blueprint $table) {
            $table->integer('nilai_akhir_magang')->nullable()->change();
            $table->string('indeks_nilai_akhir', 100)->nullable()->change();
        });
    }
};
