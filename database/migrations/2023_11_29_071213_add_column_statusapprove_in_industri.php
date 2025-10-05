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
        if (Schema::hasColumn('industri', 'statusapprove')) {
            Schema::table('industri', function (Blueprint $table) {
                $table->dropColumn('statusapprove');
            });
        }
        Schema::table('industri', function (Blueprint $table) {
            $table->tinyInteger('statusapprove')->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('industri', 'statusapprove')) {
            Schema::table('industri', function (Blueprint $table) {
                $table->dropColumn('statusapprove');
            });
        }
    }
};
