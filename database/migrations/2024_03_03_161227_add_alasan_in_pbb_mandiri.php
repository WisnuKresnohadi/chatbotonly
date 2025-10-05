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
        if (Schema::hasColumn('pbb_mandiri', 'status') && Schema::hasColumn('pbb_mandiri', 'alasan_tolak')) {
            Schema::table('pbb_mandiri', function (Blueprint $table) {
                $table->dropColumn('status');
                $table->dropColumn('alasan_tolak');
            });
        } else {
            Schema::table('pbb_mandiri', function (Blueprint $table) {
                $table->boolean('status')->nullable()->default(false);
                $table->text('alasan_tolak')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pbb_mandiri', function (Blueprint $table) {
            //
        });
    }
};
