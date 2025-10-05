<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
                $table->decimal('eprt')->default(0)->change();

                if (!Schema::hasColumn('mahasiswa', 'tipetesbahasa')) {
                    $table->string('tipetesbahasa')->nullable();
                }

                $table->decimal('ipk', 3, 2)->default(0)->change();
                $table->integer('tak')->default(0)->change();
                $table->text('alamatmhs')->nullable()->change();
                $table->string('nohpmhs', 15)->nullable()->change();
                $table->string('tunggakan_bpp', 255)->nullable()->change();

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
            //
        });
    }
};
