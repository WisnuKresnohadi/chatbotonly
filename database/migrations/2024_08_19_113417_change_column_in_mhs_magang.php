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
            $table->double('nilai_lap', 15, 2)->nullable()->change();
            $table->double('nilai_akademik', 15, 2)->nullable()->change();

            $table->string('indeks_nilai_lap', 5)->nullable();
            $table->string('indeks_nilai_akademik', 5)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mhs_magang', function (Blueprint $table) {
            $table->integer('nilai_lap')->nullable()->change();
            $table->integer('nilai_akademik')->nullable()->change();
        });
    }
};
