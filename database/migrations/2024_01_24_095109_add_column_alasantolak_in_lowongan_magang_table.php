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
        if (Schema::hasColumn('lowongan_magang', 'alasantolak')) {
            Schema::table('lowongan_magang', function (Blueprint $table) {
                $table->dropColumn('alasantolak');
            });
        } else {
            Schema::table('lowongan_magang', function (Blueprint $table) {
                $table->text('alasantolak', 255)->nullable();
            });
        }
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
