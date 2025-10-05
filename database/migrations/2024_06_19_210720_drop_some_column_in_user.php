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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('isAdmin');
            $table->dropForeign('users_id_industri_foreign');
            $table->dropColumn('id_industri');
            $table->dropForeign('users_id_mahasiswa_foreign');
            $table->dropForeign('users_nim_foreign');
            $table->dropColumn('nim');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('isAdmin')->nullable();
            $table->uuid('id_industri')->nullable();
            $table->foreign('id_industri')->references('id_industri')->on('industri');
            $table->uuid('nim')->nullable();
            $table->foreign('nim', 'users_id_mahasiswa_foreign')->references('nim')->on('mahasiswa');
            $table->foreign('nim', 'users_nim_foreign')->references('nim')->on('mahasiswa');
        });
    }
};
