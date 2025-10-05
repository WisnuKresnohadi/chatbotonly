<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Enums\PendaftaranMagangStatusEnum;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {   
        Schema::table('pendaftaran_magang', function (Blueprint $table) {
            $table->dropColumn(['konfirmasi_status', 'status_seleksi', 'current_step']);
        });

        Schema::table('pendaftaran_magang', function (Blueprint $table) {
            $table->enum('current_step', PendaftaranMagangStatusEnum::getConstants())->default(PendaftaranMagangStatusEnum::PENDING)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftaran_magang', function (Blueprint $table) {
            $table->tinyInteger('konfirmasi_status')->nullable();
            $table->tinyInteger('status_seleksi')->nullable();
            $table->dropColumn(['current_step']);
        });

        Schema::table('pendaftaran_magang', function (Blueprint $table) {
            $table->string('current_step', 100)->nullable();
        });
    }
};
