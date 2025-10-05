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
        Schema::create('pbb_mandiri', function (Blueprint $table) {
            $table->uuid('id_pbb')->primary();
            $table->string('nama', 255);
            $table->integer('nip');
            $table->string('email', 255);
            $table->string('jabatan', 255);
            $table->string('no_hp', 255);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pbb_mandiri');
    }
};
