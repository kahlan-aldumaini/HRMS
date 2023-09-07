<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shift>
 */
class ShiftFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $mainTime = Carbon::now()->subHours(rand(1, 24));

        $primaryLoginTime = $mainTime->copy()->addHours(rand(1, 10));
        $primaryExitTime = $primaryLoginTime->copy()->addHours(8);
        $secondaryLoginTime = $primaryLoginTime->copy()->addMinute(rand(1, 10));
        $secondaryExitTime = $primaryExitTime->copy()->addMinute(30);


        return [
            'name' => $this->faker->word(),
            'primary_enter' => $primaryLoginTime->format('H:i:s'),
            'primary_exit' => $primaryExitTime->format('H:i:s'),
            'secondary_enter' => $secondaryLoginTime->format('H:i:s'),
            'secondary_exit' => $secondaryExitTime->format('H:i:s'),
            'day' => Carbon::now()->addDays(rand(1, 7))->dayName,
        ];
    }
}
