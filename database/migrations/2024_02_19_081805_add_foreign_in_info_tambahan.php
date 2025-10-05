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
        if (Schema::hasColumn('info_tambahan', 'sosmed')) {
            Schema::table('info_tambahan', function (Blueprint $table) {
                $table->dropColumn('sosmed');
                $table->uuid('id_sosmed')->nullable();
                $table->foreign('id_sosmed')->references('id_sosmed')->on('sosmed');
            });
        } else {
            Schema::table('info_tambahan', function (Blueprint $table) {
                $table->uuid('id_sosmed')->nullable();
                $table->foreign('id_sosmed')->references('id_sosmed')->on('sosmed');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('info_tambahan', function (Blueprint $table) {
            //
        });
    }
};
