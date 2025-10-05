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
        Schema::table('informasi_prib', function (Blueprint $table) {
            $table->text('deskripsi_diri')->nullable()->change();
            $table->text('headliner')->change();
            $table->string('profile_picture', 255)->nullable()->change();
            $table->decimal('ipk', 5, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('informasi_prib', function (Blueprint $table) {
            //
        });
    }
};
