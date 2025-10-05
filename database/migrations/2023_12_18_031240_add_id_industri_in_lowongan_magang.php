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
        if (Schema::hasColumn('lowongan_magang', 'id_industri')) {
            Schema::table('lowongan_magang', function (Blueprint $table) {
                $table->dropColumn('id_industri');
            });
        }
        Schema::table('lowongan_magang', function (Blueprint $table) {
            $table->uuid('id_industri')->nullable();
            $table->foreign('id_industri')->references('id_industri')->on('industri');
        });
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
