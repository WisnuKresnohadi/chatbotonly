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
        Schema::table('bidang_pekerjaan_industri', function (Blueprint $table) {
            $table->uuid('id_industri')->nullable()->change();
            $table->dropColumn(['nama']);
            $table->string('namabidangpekerjaan')->after('id_industri');
            $table->boolean('status')->default(true)->after('deskripsi');
            $table->boolean('default')->default(0)->after('deskripsi');

            $table->index('namabidangpekerjaan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bidang_pekerjaan_industri', function (Blueprint $table) {
            $table->dropIndex(['namabidangpekerjaan']); // Hapus index
            $table->dropColumn(['namabidangpekerjaan', 'status', 'default']); // Hapus kolom baru
            $table->string('nama')->after('id_industri'); // Tambahkan kembali kolom 'nama'
            $table->uuid('id_industri')->nullable(false)->change(); // Ubah kembali ke tidak nullable jika sebelumnya required
        });
    }
};
