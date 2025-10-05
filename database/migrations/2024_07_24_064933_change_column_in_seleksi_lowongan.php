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
        Schema::table('seleksi_lowongan', function (Blueprint $table) {
            $table->renameColumn('id_email_tamplate', 'id_email_template');
        });

        Schema::table('seleksi_lowongan', function (Blueprint $table) {
            $table->uuid('id_email_template')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seleksi_lowongan', function (Blueprint $table) {
            $table->renameColumn('id_email_template', 'id_email_tamplate');
        });

        Schema::table('seleksi_lowongan', function (Blueprint $table) {
            $table->uuid('id_email_tamplate')->change();
        });
    }
};
