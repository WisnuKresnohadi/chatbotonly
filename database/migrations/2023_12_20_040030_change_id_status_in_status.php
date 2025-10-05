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
                $table->dropForeign('flow_next_foreign');
                $table->dropColumn('next');
            });
        }
        if (Schema::hasColumn('status', 'id_status')) {
            Schema::table('status', function (Blueprint $table) {
                $table->dropColumn('id_status');
            });
        }
        Schema::table('status', function (Blueprint $table) {
            $table->integer('id_status')->autoIncrement();
            $table->string('cat', 255)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('status', function (Blueprint $table) {
            //
        });
    }
};
