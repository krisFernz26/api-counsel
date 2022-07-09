<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Institution>
 */
class InstitutionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'approved_at' => $this->faker->boolean(50) ? Carbon::now()->format('Y-m-d H:i:s') : null,
            'name' => $this->faker->name(),
            'address' => $this->faker->address(),
            'contact_no' => $this->faker->phoneNumber(),
            'contact_email' => $this->faker->unique()->safeEmail(),
            'contact_person_name' => $this->faker->name(),
            'contact_person_no' => $this->faker->phoneNumber(),
        ];
    }
}
