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
        if (
            Schema::hasColumn('logbook_week', 'week')
            && Schema::hasColumn('logbook_week', 'alasan_tolak')
        ) {
            Schema::table('logbook_week', function (Blueprint $table) {
                $table->dropColumn('week');
                $table->dropColumn('alasan_tolak');
            });
        } else {
            Schema::table('logbook_week', function (Blueprint $table) {
                $table->string('week', 255)->nullable();
                $table->text('alasan_tolak')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('logbook_week', function (Blueprint $table) {
            //
        });
    }
};
