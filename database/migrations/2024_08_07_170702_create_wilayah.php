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
        Schema::create('reg_countries', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('name');
        });

        Schema::create('reg_provinces', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('country_id');
            $table->foreign('country_id', 'fk_country')->references('id')->on('reg_countries');
            $table->string('name');
        });

        Schema::create('reg_regencies', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('province_id');
            $table->foreign('province_id', 'fk_province')->references('id')->on('reg_provinces');
            $table->string('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reg_regencies');
        Schema::dropIfExists('reg_provinces');
        Schema::dropIfExists('reg_countries');
    }
};
