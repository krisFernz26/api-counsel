<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DefaultAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $admin = new User;
        $admin->institution_id = 1;
        $admin->role_id = 1;
        $admin->first_name = 'Kyle';
        $admin->last_name = 'Fernandez';
        $admin->username = 'kff_admin2698';
        $admin->email = 'kfernz2626@gmail.com';
        $admin->password = Hash::make("counselor_admin123");
        $admin->save();

    }
}
