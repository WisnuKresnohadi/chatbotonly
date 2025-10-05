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
        if (!Schema::hasColumn('mahasiswa', 'tesbahasa')) {
            Schema::table('mahasiswa', function (Blueprint $table) {
                $table->integer('angkatan')->nullable()->change();
                $table->decimal('tesbahasa')->nullable()->after('kode_dosen');

                if (!Schema::hasColumn('mahasiswa', 'tipetesbahasa')) {
                    $table->string('tipetesbahasa')->nullable();
                }

                $table->decimal('ipk', 3, 2)->nullable()->change();
                $table->integer('tak')->nullable()->change();
                $table->string('alamatmhs', 255)->nullable()->change();
                $table->string('nohpmhs', 15)->nullable()->change();
                $table->string('tunggakan_bpp', 255)->nullable()->change();
                $table->dropColumn('eprt');

                if (!Schema::hasColumn('mahasiswa', 'created_at')) {
                    $table->timestamps();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->integer('angkatan')->nullable(false)->change();
            $table->decimal('ipk', 3, 2)->nullable(false)->change();
            $table->integer('tak')->nullable(false)->change();
            $table->string('alamatmhs', 255)->nullable(false)->change();
            $table->string('nohpmhs', 15)->nullable(false)->change();
            $table->string('tunggakan_bpp', 255)->nullable(false)->change();
            $table->dropColumn(['tesbahasa', 'tipetesbahasa', 'created_at', 'updated_at']);
            $table->string('eprt', 255)->nullable();
        });
    }
};
