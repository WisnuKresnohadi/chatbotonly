<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function __construct()
    {
        $this->listTable = ['bahasa_mahasiswas', 'education', 'experience', 'pekerjaan_tersimpans', 'pendaftaran_magang', 'sertifikat', 'sosmed_tambahans'];
    }
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        foreach ($this->listTable as $key => $value) {
            if (Schema::hasIndex($value, $value.'_nim_foreign')) {
                Schema::table($value, function (Blueprint $table) {
                    $table->dropForeign(['nim']);
                });
            }
            Schema::table($value, function (Blueprint $table) {
                $table->foreign('nim')->references('nim')->on('mahasiswa')->onUpdate('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach ($this->listTable as $key => $value) {
            Schema::table($value, function (Blueprint $table) {
                $table->dropForeign(['nim']);
            });
            Schema::table($value, function (Blueprint $table) {
                $table->foreign('nim')->references('nim')->on('mahasiswa')->onUpdate('restrict');
            });
        }
    }
};
