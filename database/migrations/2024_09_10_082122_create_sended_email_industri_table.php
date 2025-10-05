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
        Schema::create('sended_email_industri', function (Blueprint $table) {
            $table->uuid('id_sended_email')->primary();

            $table->uuid('id_industri')->nullable();
            $table->uuid('id_email_template')->nullable();
            $table->unsignedBigInteger('sender_id')->nullable();
            $table->string('sender')->nullable();
            $table->unsignedBigInteger('id_send_to')->nullable();

            $table->string('subject')->nullable();
            $table->string('send_to')->nullable();
            $table->string('proses')->nullable();
            $table->longText('content')->nullable();

            $table->timestamps();
        });

        Schema::table('sended_email_industri', function (Blueprint $table) {
            $table->foreign('id_industri')->references('id_industri')->on('industri');
            $table->foreign('id_email_template')->references('id_email_template')->on('email_template');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sended_email_industri', function (Blueprint $table) {
            $table->dropForeign(['id_industri']);
            $table->dropForeign(['id_email_template']);
        });

        Schema::dropIfExists('sended_email_industri');
    }
};
