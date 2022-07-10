<?php

namespace Database\Factories;

use App\Models\CounselorSchedule;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DailySchedule>
 */
class DailyScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
           'counselor_schedule_id' => CounselorSchedule::all()->random()->id,
           'date' => $this->faker->boolean(50) ? $this->faker->date('Y-m-d') : null,
           'day' => $this->faker->dayOfWeek(),
           'start_time' => $this->faker->time(),
           'end_time' => $this->faker->time(), 
        ];
    }
}
