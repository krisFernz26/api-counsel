<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            AppointmentStatusSeeder::class,
        ]);
        \App\Models\Institution::factory(10)->create();
        \App\Models\User::factory(50)->create();
        \App\Models\Note::factory(60)->create();
        \App\Models\Appointment::factory(20)->create();
        \App\Models\CounselorSchedule::factory(100)->create();
        \App\Models\DailySchedule::factory(100)->create();
    }
}
