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
        if (Schema::hasColumn('users', 'id_mahasiswa')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropForeign('users_id_mahasiswa_foreign');
                $table->dropColumn('id_mahasiswa');
            });
        }
        Schema::table('users', function (Blueprint $table) {
            $table->uuid('id_mahasiswa')->nullable()->change(null);
            $table->foreign('id_mahasiswa')->references('nim')->on('mahasiswa')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('users', 'id_mahasiswa')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('id_mahasiswa');
            });
        }
    }
};
