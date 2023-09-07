<?php

namespace Database\Factories;

use App\Enum\PeriodState;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Period>
 */
class PeriodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $now = Carbon::now();
        return [
            'start' => $this->faker->date(),
            'end' => $this->faker->date(),
            'month' => $now->month,
            'year' => $now->year,
            'state' => $this->faker->randomElement(array_map(fn ($q) => $q->value, PeriodState::cases())),
        ];
    }
}
