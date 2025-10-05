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

        Schema::dropIfExists('nilai_akhir_mk');

        Schema::create('nilai_akhir_mhs', function (Blueprint $table) {
            $table->uuid('id_nilai_akhir_mhs')->primary();
            $table->string('nim');
            $table->uuid('id_mk')->nullable();
            $table->tinyInteger('semester');
            $table->decimal('nilai_mk')->nullable();
            $table->char('predikat', 5)->nullable();            

            $table->foreign('nim')
                ->references('nim')
                ->on('mahasiswa')
                ->onDelete('cascade');  // Cascade on delete

            $table->foreign('id_mk')
                ->references('id_mk')
                ->on('mata_kuliah')
                ->onDelete('cascade');  // Cascade on delete

            $table->timestamps();         
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_akhir_mhs');
    }
};
