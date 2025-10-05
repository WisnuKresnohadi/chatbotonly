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
        if (Schema::hasColumn('lowongan_magang', 'id_flow')) {
            Schema::table('lowongan_magang', function (Blueprint $table) {
                // $table->dropForeign('lowongan_magang_id_flow_foreign');
                $table->dropColumn('id_flow');
            });
        }
        Schema::table('lowongan_magang', function (Blueprint $table) {
            $table->integer('id_flow')->nullable();
            $table->foreign('id_flow')->references('id_flow')->on('flow');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lowongan_magang', function (Blueprint $table) {
            //
        });
    }
};
