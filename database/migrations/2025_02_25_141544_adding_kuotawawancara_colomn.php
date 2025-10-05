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
        Schema::table('hasil_wawancara', function (Blueprint $table){
            $table->integer('kuota_wawancara');
            $table->longText('kesimpulan_wawancara')->nullable(true)->change();
            $table->json('skoring_wawancara')->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hasil_wawancara', function (Blueprint $table){
        $table->dropColumn('kuota_wawancara');
        $table->longText('kesimpulan_wawancara')->nullable(false)->change();
        $table->json('skoring_wawancara')->nullable(false)->change();
        });
    }
};
