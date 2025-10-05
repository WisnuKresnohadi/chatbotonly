<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// use Illuminate\Support\Facades\Schema;

class LocationSeeder extends Seeder
{
    public function run()
    {
        // DB::beginTransaction();
        try {
            Schema::disableForeignKeyConstraints();     
            $sql1 = file_get_contents(database_path('sql/wilayah_indonesia.sql'));
            DB::unprepared($sql1);
            // DB::commit();
        } catch (\Exception $e) {
            // DB::rollBack();
            throw $e;
        }
        //Begin transaction tidak bisa karena dipengaruhi oleh drop table pada file wilayah_indonesia.sql
    }
}