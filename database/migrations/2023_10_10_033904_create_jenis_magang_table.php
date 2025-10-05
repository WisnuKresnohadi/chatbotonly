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
        Schema::create('jenis_magang', function (Blueprint $table) {
            $table->uuid('id_jenismagang')->primary();
            $table->string('namajenis', 255);
            $table->integer('durasimagang');
            $table->boolean('is_review_process')->default(false);
            $table->boolean('is_document_upload')->default(false);
            $table->string('type', 255);
            $table->boolean('status')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_magang');
    }
};
