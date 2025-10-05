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
        if (Schema::hasColumn('informasi_prib', 'gender')) {
            Schema::table('informasi_prib', function (Blueprint $table) {
                $table->dropColumn('gender');
            });
        } else {
            Schema::table('informasi_prib', function (Blueprint $table) {
                $table->string('gender', 255);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('informasi_prib', function (Blueprint $table) {
            //
        });
    }
};
