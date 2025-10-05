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
        if (Schema::hasColumn('users', 'id_industri')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropForeign('users_id_industri_foreign');
                $table->dropColumn('id_industri');
            });
        }
        Schema::table('users', function (Blueprint $table) {
            $table->uuid('id_industri')->nullable()->change(null);
            $table->foreign('id_industri')->references('id_industri')->on('industri')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('users', 'id_industri')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('id_industri');
            });
        }
    }
};
