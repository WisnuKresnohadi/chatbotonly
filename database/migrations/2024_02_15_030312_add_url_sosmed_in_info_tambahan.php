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
        if (Schema::hasColumn('info_tambahan', 'url_sosmed')) {
            Schema::table('info_tambahan', function (Blueprint $table) {
                $table->dropColumn('url_sosmed');
            });
        } else {
            Schema::table('info_tambahan', function (Blueprint $table) {
                $table->text('url_sosmed')->nullable();
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
