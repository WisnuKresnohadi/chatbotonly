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
        Schema::table('seleksi', function (Blueprint $table) {
            $table->boolean('statusseleksi')->default(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('seleksi', 'statusseleksi')) {
            Schema::table('seleksi', function (Blueprint $table) {
                $table->dropColumn('statusseleksi');
            });
        }
    }
};
