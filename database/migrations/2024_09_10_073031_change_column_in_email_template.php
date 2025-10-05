<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE email_template MODIFY COLUMN proses enum('lolos_seleksi','penjadwalan_seleksi','diterima_magang','tidak_lolos_seleksi') NULL;");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE email_template MODIFY COLUMN proses enum('lolos_seleksi','penjadwalan_seleksi','tidak_lolos_seleksi') NULL;");
    }
};
