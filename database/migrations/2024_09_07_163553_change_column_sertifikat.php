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
        Schema::table('sertifikat', function (Blueprint $table) {
            $table->string('nama_sertif')->nullable()->change();
            $table->string('penerbit')->nullable()->change();
            $table->date('startdate')->nullable()->change();
            $table->date('enddate')->nullable()->change();
            $table->string('file_sertif')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sertifikat', function (Blueprint $table) {
            $table->string('nama_sertif')->nullable(false)->change();
            $table->string('penerbit')->nullable(false)->change();
            $table->date('startdate')->nullable(false)->change();
            $table->date('enddate')->nullable(false)->change();
            $table->string('file_sertif')->nullable(false)->change();
        });
    }
};
