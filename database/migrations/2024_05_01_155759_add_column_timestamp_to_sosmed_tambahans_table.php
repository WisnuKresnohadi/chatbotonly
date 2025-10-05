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
        Schema::table('sosmed_tambahans', function (Blueprint $table) {
            $table->id('sosmed_tambahans_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sosmed_tambahans', function (Blueprint $table) {
            $table->dropColumn('sosmed_tambahans_id');
            $table->timestamps();
        });
    }
};
