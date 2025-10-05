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
        Schema::create('bidang_pekerjaan_mk_item', function (Blueprint $table) {
            $table->uuid('id_bidang_pekerjaan_mk');
            $table->uuid('id_mk');
            
            $table->foreign('id_bidang_pekerjaan_mk')
                ->references('id_bidang_pekerjaan_mk')
                ->on('bidang_pekerjaan_mk')
                ->onDelete('cascade');
            $table->foreign('id_mk')
                ->references('id_mk')
                ->on('mata_kuliah')
                ->onDelete('cascade');
            
            $table->unique(['id_bidang_pekerjaan_mk', 'id_mk']);

            $table->index('id_bidang_pekerjaan_mk');
            $table->index('id_mk');
            $table->timestamps();         
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bidang_pekerjaan_mk_item');
    }
};
