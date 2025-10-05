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
        if (Schema::hasColumn('pengajuan_mandiri', 'alasan_tolak')) {
            Schema::table('pengajuan_mandiri', function (Blueprint $table) {
                $table->dropColumn('alasan_tolak');
            });
        } else {
            Schema::table('pengajuan_mandiri', function (Blueprint $table) {
                $table->text('alasan_tolak')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_mandiri', function (Blueprint $table) {
            //
        });
    }
};
