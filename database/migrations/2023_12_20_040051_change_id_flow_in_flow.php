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
        if (Schema::hasColumn('flow', 'next')) {
            Schema::table('flow', function (Blueprint $table) {
                // $table->dropForeign('flow_next_foreign');
                // $table->dropColumn('next');
            });
        }
        Schema::table('flow', function (Blueprint $table) {
            $table->integer('id_flow')->autoIncrement()->change();
            $table->integer('next')->nullable();
            $table->foreign('next')->references('id_status')->on('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('flow', function (Blueprint $table) {
            //
        });
    }
};

