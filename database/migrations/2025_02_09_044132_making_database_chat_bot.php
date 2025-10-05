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
        //Create Table hasil_wawancara
        Schema::create('hasil_wawancara', function (Blueprint $table) {
            $table->string('nim', 255)->index();
            $table->integer('id_wawancara')->index();
            $table->longText('kesimpulan_wawancara');
            $table->json('skoring_wawancara');

            // Adding foreign keys
            $table->foreign('nim')->references('nim')->on('mahasiswa')->onDelete('cascade')->onUpdate('cascade');
        });


        //Create table wawancara_magang
        Schema::create('wawancara_magang', function (Blueprint $table) {
            $table->integer('id_wawancara', true);
            $table->char('id_lowongan', 36)->index();
            $table->json('list_kriteria_softskill');

            //adding foreign keys
            $table->foreign('id_lowongan')->references('id_lowongan')->on('lowongan_magang')->onDelete('cascade')->onUpdate('cascade');
        });

        //Create table bank_soal
        Schema::create('bank_soal', function (Blueprint $table) {
            $table->integer('id_kriteria', true);
            $table->json('list_pertanyaan');
            $table->string('kriteria_softskill', 50);
        });

        //Create relationship in hasil wawancara table
        Schema::table('hasil_wawancara', function (Blueprint $table) {
            $table->foreign('id_wawancara')->references('id_wawancara')->on('wawancara_magang')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop tabel dalam urutan yang sesuai untuk menghindari error karena foreign key
        Schema::dropIfExists('hasil_wawancara');
        Schema::dropIfExists('wawancara_magang');
        Schema::dropIfExists('bank_soal');
    }
};
