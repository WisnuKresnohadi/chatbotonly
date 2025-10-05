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
        if (Schema::hasColumn('logbook_week', 'date_approvelap') && Schema::hasColumn('logbook_week', 'approve_akademik') && Schema::hasColumn('logbook_week', 'Week')) {
            Schema::table('logbook_week', function (Blueprint $table) {
                $table->dropColumn('date_approvelap');
                $table->dropColumn('approve_akademik');
                $table->dropColumn('Week');
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
