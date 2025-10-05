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
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->dropColumn(['sosmed', 'url_sosmed', 'bahasa']);
            $table->string('lokasi_yg_diharapkan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->string('sosmed')->nullable();
            $table->string('url_sosmed')->nullable();
            $table->string('bahasa')->nullable();

            $table->dropColumn('lokasi_yg_diharapkan');
        });
    }
};
