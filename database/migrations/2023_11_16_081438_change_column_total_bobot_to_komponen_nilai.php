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
        Schema::table('komponen_nilai', function (Blueprint $table) {
            $table->integer('total_bobot')->default(0)->change();
            $table->string('tipe', 255)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('komponen_nilai', function (Blueprint $table) {
            Schema::dropIfExists('komponen_nilai', 'total_bobot');
            Schema::dropIfExists('komponen_nilai', 'tipe');
        });
    }
};
