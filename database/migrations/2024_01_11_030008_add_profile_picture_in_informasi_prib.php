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
        if (Schema::hasColumn('informasi_prib', 'profile_picture')) {
            Schema::table('informasi_prib', function (Blueprint $table) {
                $table->dropColumn('profile_picture');
            });
        } else {
            Schema::table('informasi_prib', function (Blueprint $table) {
                $table->string('profile_picture', 255);
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
