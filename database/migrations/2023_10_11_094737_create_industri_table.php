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
        Schema::create('industri', function (Blueprint $table) {
            $table->Uuid('id_industri')->primary();
            $table->string('namaindustri', 255);
            $table->string('notelpon', 15);
            $table->string('alamatindustri', 255);
            $table->boolean('kategori_industri');
            $table->boolean('statuskerjasama')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('industri');
    }
};

