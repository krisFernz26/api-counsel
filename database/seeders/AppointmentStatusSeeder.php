<?php

namespace Database\Seeders;

use App\Models\AppointmentStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppointmentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = new AppointmentStatus;
        $status->title = 'Coming up';
        $status->description = 'Appointment is coming up.';
        $status->save();

        $status = new AppointmentStatus;
        $status->title = 'In progress';
        $status->description = 'Appointment is being held.';
        $status->save();

        $status = new AppointmentStatus;
        $status->title = 'Done';
        $status->description = 'Appointment was held.';
        $status->save();

        $status = new AppointmentStatus;
        $status->title = 'Cancelled';
        $status->description = 'Appointment was cancelled.';
        $status->save();
    }
}
