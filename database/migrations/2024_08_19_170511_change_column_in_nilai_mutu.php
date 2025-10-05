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
        Schema::table('nilai_mutu', function (Blueprint $table) {
            $table->double('nilaimin')->change();
            $table->double('nilaimax')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nilai_mutu', function (Blueprint $table) {
            $table->string('nilaimin', 5)->change();
            $table->string('nilaimax', 5)->change();
        });
    }
};
