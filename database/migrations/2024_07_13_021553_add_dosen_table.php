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
        Schema::table('dosen', function (Blueprint $table) {
            $table->uuid('id_fakultas')->nullable();
            $table->unsignedBigInteger('id_user')->nullable();
            $table->foreign('id_fakultas')->references('id_fakultas')->on('fakultas');
            $table->foreign('id_user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dosen', function (Blueprint $table) {
            $table->dropForeign(['id_fakultas']);
            $table->dropColumn('id_fakultas');
            $table->dropForeign(['id_user']);
            $table->dropColumn('id_user');
        });
    }
};
