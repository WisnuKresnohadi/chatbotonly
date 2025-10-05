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
        if (Schema::hasColumn('lowongan_magang', 'nominal_salary')) {
            Schema::table('lowongan_magang', function (Blueprint $table) {
                $table->dropColumn('nominal_salary');
            });
        } else {
            Schema::table('lowongan_magang', function (Blueprint $table) {
                $table->string('nominal_salary', 255);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lowongan_magang', function (Blueprint $table) {
            //
        });
    }
};
