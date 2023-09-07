<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'phone' => $this->faker->phoneNumber(),
            'name' => $this->faker->name(),
            'employee_number' => $this->faker->numberBetween(5000, 10000),
            'sex' => $this->faker->randomElement(["ذكر", "انثى"]),
            'marital_state' => $this->faker->randomElement(["اعزب", "متززوج"]),
            'birthdate' => $this->faker->date(max: '10-1-2008'),
            'place_of_residence' => $this->faker->address(),
        ];
    }
}
