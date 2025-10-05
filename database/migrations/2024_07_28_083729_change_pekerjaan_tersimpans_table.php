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
        Schema::table('pekerjaan_tersimpans', function (Blueprint $table) {
            $table->dropColumn('job_name');
            $table->string('nim')->nullable();
            $table->uuid('id_lowongan')->nullable();
            $table->foreign('nim')->references('nim')->on('mahasiswa');
            $table->foreign('id_lowongan')->references('id_lowongan')->on('lowongan_magang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pekerjaan_tersimpans', function (Blueprint $table) {
            $table->string('job_name', 100);
            $table->dropForeign(['nim']);
            $table->dropForeign(['id_lowongan']);
            $table->dropColumn('nim');
            $table->dropColumn('id_lowongan');
            
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
        });
    }
};
