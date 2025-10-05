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
        Schema::table('email_template', function (Blueprint $table) {
            $table->uuid('id_industri')->nullable();
            $table->foreign('id_industri')->references('id_industri')->on('industri');

            $table->enum('proses', ['lolos_seleksi', 'penjadwalan_seleksi', 'tidak_lolos_seleksi'])->nullable();

            $table->string('subject_email')->nullable()->change();
            $table->string('headline_email')->nullable()->change();
            $table->longText('content_email')->nullable()->change();
            $table->dropColumn('attachment');
            $table->dropColumn('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('email_template', function (Blueprint $table) {
            $table->dropForeign(['id_industri']);
            $table->dropColumn('id_industri');

            $table->dropColumn('proses');

            $table->string('subject_email')->nullable(false)->change();
            $table->string('headline_email')->nullable(false)->change();
            $table->string('content_email')->nullable(false)->change();
            $table->string('attachment');
            $table->string('status');
        });
    }
};
