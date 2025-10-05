<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    public function __construct()
    {
        $this->reg = ['reg_countries', 'reg_provinces', 'reg_regencies'];
    }

    public function up(): void
    {
        Schema::disableForeignKeyConstraints();
        foreach($this->reg as $table){
            Schema::table($table, function (Blueprint $table) {
                $table->integer('id')->autoIncrement()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
