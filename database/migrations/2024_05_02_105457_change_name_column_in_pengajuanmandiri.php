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
       
            Schema::table('pengajuan_mandiri', function (Blueprint $table) {
                $table->dateTime('tgl_pengajuan', 255)->change();
                $table->boolean('status_approve', 255)->nullable()->change();
                $table->boolean('status_terima')->nullable()->change();
                $table->string('letter_to', 255)->change();
                $table->string('dokumen_spm', 255)->nullable()->change();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_mandiri', function (Blueprint $table) {
            $table->dateTime('tgl_pengajuan', 255)->change();
            $table->boolean('status_approve', 255)->nullable()->change();
            $table->boolean('status_terima')->nullable()->change();
            $table->string('letter_to', 255)->change();
            $table->string('dokumen_spm', 255)->nullable()->change();
        });
    }
};