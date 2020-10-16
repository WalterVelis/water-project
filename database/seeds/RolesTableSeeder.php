<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role= new Role();
        $role->name='Admin';
        $role->description='This is the administration role';
        $role->save();

        $role= new Role();
        $role->name='Vendor';
        $role->description='This is the vendor role';
        $role->save();

    }
}