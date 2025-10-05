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
        Schema::table('industri', function (Blueprint $table) {
            $table->string('notelpon', 15)->nullable()->change();
            $table->string('alamatindustri', 255)->nullable()->change();
            $table->string('kategori_industri', 255)->nullable()->change();
            $table->string('statuskerjasama', 255)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('industri', function (Blueprint $table) {
            Schema::dropIfExists('industri', 'notelpon');
            Schema::dropIfExists('industri', 'alamatindustri');
            Schema::dropIfExists('industri', 'kategori_industri');
            Schema::dropIfExists('industri', 'statuskerjasama');
        });
    }
};
