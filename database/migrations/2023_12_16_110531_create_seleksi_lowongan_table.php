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
        Schema::create('seleksi_lowongan', function (Blueprint $table) {
            $table->uuid('id_seleksi_lowongan')->primary();
            $table->uuid('id_email_tamplate');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('no_tahapan')->default(1);
            $table->string('namatahap_seleksi', 255);
            $table->foreign('id_email_tamplate')->references('id_email_tamplate')->on('email_template');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seleksi_lowongan');
    }
};
