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
        DB::table(table: 'mata_kuliah')->delete();        

        Schema::table('bidang_pekerjaan_mk', function (Blueprint $table) {
            $table->dropForeign(['kode_mk']);
            $table->dropColumn('kode_mk');
        });

        Schema::table('nilai_akhir_mk', function (Blueprint $table) {
            $table->dropForeign(['kode_mk']);
            $table->dropColumn('kode_mk');
        });

        Schema::table('mata_kuliah', callback: function (Blueprint $table) {                      
            $table->dropPrimary('kode_mk');                             
            $table->dropColumn('kode_mk');  
            $table->uuid('id_mk')->primary()->first();  
            $table->string('kurikulum', 20);     
            $table->timestamps();                      
        });

        Schema::table('mata_kuliah', function (Blueprint $table) {            
            $table->string('kode_mk')->after('id_prodi');
        });

        Schema::table('bidang_pekerjaan_mk', function (Blueprint $table) {
            $table->uuid('id_mk');
            $table->foreign('id_mk')->references('id_mk')->on('mata_kuliah')->onDelete('cascade');
        });

        Schema::table('nilai_akhir_mk', function (Blueprint $table) {
            $table->uuid('id_mk');
            $table->foreign('id_mk')->references('id_mk')->on('mata_kuliah')->on('mata_kuliah')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Step 1: Remove the new `id_mk` column and restore `kode_mk` as primary key
        Schema::table('mata_kuliah', function (Blueprint $table) {
            // Drop foreign keys related to `id_mk` in related tables first
            Schema::table('bidang_pekerjaan_mk', function (Blueprint $table) {
                $table->dropForeign(['id_mk']);
                $table->dropColumn('id_mk');
            });

            Schema::table('nilai_akhir_mk', function (Blueprint $table) {
                $table->dropForeign(['id_mk']);
                $table->dropColumn('id_mk');
            });

            // Drop the primary key `id_mk` and restore `kode_mk` as primary key
            $table->dropPrimary(['id_mk']);
            $table->string('kode_mk', 255)->primary();            
        });

        // Step 2: Re-add `kode_mk` column in related tables with foreign key constraints
        Schema::table('bidang_pekerjaan_mk', function (Blueprint $table) {
            $table->string('kode_mk', 255);
            $table->foreign('kode_mk')->references('kode_mk')->on('mata_kuliah')->onDelete('cascade');
        });

        Schema::table('nilai_akhir_mk', function (Blueprint $table) {
            $table->string('kode_mk', 255);
            $table->foreign('kode_mk')->references('kode_mk')->on('mata_kuliah');
        });
    }
};