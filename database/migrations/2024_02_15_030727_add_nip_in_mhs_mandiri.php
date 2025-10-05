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
        if (Schema::hasColumn('mhs_mandiri', 'nip') && Schema::hasColumn('mhs_mandiri', 'id_pbb')) {
            Schema::table('mhs_mandiri', function (Blueprint $table) {
                $table->dropForeign('mhs_mandiri_nip_foreign');
                $table->dropForeign('mhs_mandiri_id_pbb_foreign');
                $table->dropColumn('nip');
                $table->dropColumn('id_pbb');
            });
        } else {
            Schema::table('mhs_mandiri', function (Blueprint $table) {
                $table->integer('nip')->nullable();
                $table->uuid('id_pbb')->nullable();
                $table->foreign('nip')->references('nip')->on('dosen');
                $table->foreign('id_pbb')->references('id_pbb')->on('pbb_mandiri');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mhs_mandiri', function (Blueprint $table) {
            //
        });
    }
};
