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
        Schema::dropIfExists('informasi_prib');
        Schema::table('mahasiswa', function (Blueprint $table) {
        
            $table->date('tgl_lahir')->nullable();
            $table->string('headliner')->nullable();
            $table->longText('deskripsi_diri')->nullable();
            $table->string('profile_picture')->nullable();
            $table->string('gender')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('informasi_prib', function (Blueprint $table) {
            $table->uuid('id_infoprib')->primary();
            $table->string('nim');
            $table->foreign('nim')->references('nim')->on('mahasiswa');
            $table->decimal('ipk', 3, 2)->nullable();
            $table->integer('eprt')->nullable();
            $table->integer('TAK')->nullable();
            $table->date('tgl_lahir');
            $table->text('headliner');
            $table->text('deskripsi_diri')->nullable();
            $table->string('profile_picture')->nullable();
            $table->string('gender');
        });

        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->dropColumn(['tgl_lahir', 'headliner', 'deskripsi_diri', 'profile_picture', 'gender']);
        });
    }
};
