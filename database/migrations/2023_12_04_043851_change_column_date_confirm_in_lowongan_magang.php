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
        Schema::table('lowongan_magang', function (Blueprint $table) {
            $table->date('date_confirm_closing')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('lowongan_magang', 'date_confirm_closing')) {
            Schema::table('lowongan_magang', function (Blueprint $table) {
                $table->dropColumn('date_confirm_closing');
            });
        }
    }
};
