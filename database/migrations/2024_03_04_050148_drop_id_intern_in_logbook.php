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
        if (Schema::hasColumn('logbook', 'id_intern_confirm')) {
            Schema::table('logbook', function (Blueprint $table) {
                $table->dropForeign('logbook_id_intern_confirm_foreign');
                $table->dropColumn('id_intern_confirm');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('logbook', function (Blueprint $table) {
            //
        });
    }
};
