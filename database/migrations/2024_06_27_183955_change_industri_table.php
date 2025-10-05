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
            $table->dropForeign('industri_id_user_foreign');
            $table->dropColumn('id_user');

            $table->uuid('penanggung_jawab')->nullable()->change();
            $table->foreign('penanggung_jawab')->references('id_peg_industri')->on('pegawai_industri');

            $table->string('email')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('industri', function (Blueprint $table) {
            $table->dropForeign('industri_penanggung_jawab_foreign');
        });

        Schema::table('industri', function (Blueprint $table) {
            $table->string('email')->nullable(false)->change();
            $table->string('penanggung_jawab')->nullable()->change();

            $table->unsignedBigInteger('id_user')->nullable();
            $table->foreign('id_user')->references('id')->on('users');
        });
    }
};
