<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class)->create([
            'name' => 'Admin',
            'email' => 'admin@material.com',
            //'email' => 'jorge.ovi10@gmail.com',
            'role_id' => 1,
        ]);

        factory(App\User::class)->create([
            'name' => 'Admin',
            'email' => 'waltervelis45@gmail.com',
            //'email' => 'jorge.ovi10@gmail.com',
            'role_id' => 1,
        ]);
    }
}