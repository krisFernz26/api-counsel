<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $role = new Role;
        $role->name = 'admin';
        $role->save();

        $role = new Role;
        $role->name = 'institution';
        $role->save();

        $role = new Role;
        $role->name = 'cousnelor';
        $role->save();

        $role = new Role;
        $role->name = 'student';
        $role->save();
    }
}
