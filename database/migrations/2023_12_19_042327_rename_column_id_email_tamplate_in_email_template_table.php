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
            $table->renameColumn('id_email_tamplate', 'id_email_template');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('email_template', 'id_email_template')) {
            Schema::table('email_template', function (Blueprint $table) {
                $table->dropColumn('id_email_template');
            });
        }
    }
};