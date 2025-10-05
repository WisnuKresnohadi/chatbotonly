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
        if (
            Schema::hasColumn('pengajuan_mandiri', 'tgl_pengajuan')
            && Schema::hasColumn('pengajuan_mandiri', 'status_approve')
            && Schema::hasColumn('pengajuan_mandiri', 'status_terima')
            && Schema::hasColumn('pengajuan_mandiri', 'letter_to')
            && Schema::hasColumn('pengajuan_mandiri', 'dokumen_spm')
        ) {
            Schema::table('pengajuan_mandiri', function (Blueprint $table) {
                $table->dropColumn('tgl_pengajuan');
                $table->dropColumn('status_approve');
                $table->dropColumn('status_terima');
                $table->dropColumn('letter_to');
                $table->dropColumn('dokumen_spm');
            });
        } else {
            Schema::table('pengajuan_mandiri', function (Blueprint $table) {
                $table->string('letter_to', 255)->nullable();
                $table->string('dokumen_spm', 255)->nullable();
                $table->dateTime('tgl_pengajuan')->nullable()->default(now());
                $table->boolean('status_approve')->nullable();
                $table->boolean('status_terima')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_mandiri', function (Blueprint $table) {
            //
        });
    }
};
