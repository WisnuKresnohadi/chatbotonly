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
        if (Schema::hasColumn('info_tambahan', 'id_sosmed')) {
            Schema::table('info_tambahan', function (Blueprint $table) {
                $table->dropForeign('info_tambahan_id_sosmed_foreign');
                $table->dropColumn('id_sosmed');
                $table->string('sosmed', 255)->nullable();
            });
        } elseif (Schema::hasColumn('info_tambahan', 'sosmed')) {
            Schema::table('info_tambahan', function (Blueprint $table) {
                $table->dropColumn('sosmed');
                $table->string('sosmed', 255)->nullable();
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
