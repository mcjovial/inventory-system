<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        $adminRole = Role::where('name', 'admin')->first();
        $secretaryRole = Role::where('name', 'secretary')->first();
        $sellerRole = Role::where('name', 'seller')->first();

        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@email.com',
            'password' => bcrypt('admin')
        ]);

        $secretary = User::create([
            'name' => 'secretary',
            'email' => 'secretary@email.com',
            'password' => bcrypt('secretary')
        ]);

        $seller = User::create([
            'name' => 'seller',
            'email' => 'seller@email.com',
            'password' => bcrypt('seller')
        ]);

        $admin->roles()->attach($adminRole);
        $secretary->roles()->attach($secretaryRole);
        $seller->roles()->attach($sellerRole);
    }
}
