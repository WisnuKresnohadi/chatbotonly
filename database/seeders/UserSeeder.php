<?php

namespace Database\Seeders;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Contracts\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $administrator = User::firstOrNew([
            'email' => 'superadmin@gmail.com',
            'username' => 'Super Admin'
        ], [
            'name' => 'Super Admin',
            'password' => bcrypt('password'),
        ]);

        if (!$administrator->exists) {
            $administrator->save();
            $administrator->assignRole('Super Admin');
        }

        // $mitra = User::firstOrNew([
        //     'email' => 'mitra@gmail.com',
        //     'username' => 'Mitra'
        // ], [
        //     'name' => 'Mitra',
        //     'password' => bcrypt('password'),
        // ]);

        // if (!$mitra->exists) {
        //     $mitra->save();
        //     $mitra->assignRole('Mitra');
        // }
        
    }
}
