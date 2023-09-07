<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\GroupOfSets;
use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Fingerprint>
 */
class FingerprintFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $shift = Shift::factory()->create([
            'group_of_sets_id' => GroupOfSets::factory(1)->create()->first()->id
        ])->orderByDesc('id')->first();

        $loginTime = Carbon::parse($shift->primary_enter)
            ->addMinute(
                rand(
                    1,
                    Carbon::parse($shift->primary_exit)
                        ->diffInMinutes(
                            Carbon::parse($shift->primary_enter)
                        )
                )
            )
            ->format('H:i:s');

        $exitTime = Carbon::parse($shift->secondary_enter)
            ->addMinute(
                rand(
                    1,
                    Carbon::parse($shift->primary_exit)->diffInMinutes(
                        Carbon::parse($shift->secondary_exit)
                    )
                )
            )
            ->format('H:i:s');
        return [
            'login' => $loginTime,
            'exit' => $exitTime,
            'device_number' => $this->faker->randomNumber(5),
            'shift_id' => $shift->id,
        ];
    }
}
