<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');                
        
        Schema::table('bidang_pekerjaan_mk', function (Blueprint $table) {
            $table->dropForeign(['id_mk']);                     
            $table->dropColumn('id_mk');   
            $table->timestamps();                           
        });      
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('bidang_pekerjaan_mk_item');
    }
};
