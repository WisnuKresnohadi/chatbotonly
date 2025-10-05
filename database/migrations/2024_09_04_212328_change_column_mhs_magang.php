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
            $table->double('nilai_adjust')->nullable()->change();
            $table->string('indeks_nilai_adjust', 5)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mhs_magang', function (Blueprint $table) {
            $table->double('nilai_adjust')->nullable()->change();
            $table->dropColumn('indeks_nilai_adjust');
        });
    }
};
