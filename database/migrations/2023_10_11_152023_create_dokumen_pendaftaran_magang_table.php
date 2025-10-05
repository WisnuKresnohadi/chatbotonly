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
        Schema::create('dokumen_pendaftaran_magang', function (Blueprint $table) {
            $table->uuid('id_doc_pendaftaran')->primary();
            $table->uuid('id_pendaftaran');
            $table->uuid('id_document');
            $table->string('file', 255);
            $table->timestamp('date_time');
            $table->boolean('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_pendaftaran_magang');
    }
};
