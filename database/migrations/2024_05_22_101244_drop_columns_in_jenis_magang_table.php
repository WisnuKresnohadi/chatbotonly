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
        if (Schema::hasColumn('jenis_magang', 'is_review_process')) {
            Schema::table('jenis_magang', function (Blueprint $table) {
                $table->dropColumn('is_review_process');
            });
        }
        if (Schema::hasColumn('jenis_magang', 'is_document_upload')) {
            Schema::table('jenis_magang', function (Blueprint $table) {
                $table->dropColumn('is_document_upload');
            });
        }
        if (Schema::hasColumn('jenis_magang', 'type')) {
            Schema::table('jenis_magang', function (Blueprint $table) {
                $table->dropColumn('type');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jenis_magang', function (Blueprint $table) {
            //
        });
    }
};
