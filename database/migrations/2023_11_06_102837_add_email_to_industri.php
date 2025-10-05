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
        if (Schema::hasColumn('industri', 'email')) {
            Schema::table('industri', function (Blueprint $table) {
                $table->dropColumn('email');
            });
        }

        Schema::table('industri', function (Blueprint $table) {
            $table->string('email', 255);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('industri', 'email')) {
            Schema::table('industri', function (Blueprint $table) {
                $table->dropColumn('email');
            });
        }
    }
};
