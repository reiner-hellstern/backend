<?php

namespace Database\Factories;

use App\Models\Person;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DsgvoErklaerung>
 */
class DsgvoErklaerungFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $zugestimmt = $this->faker->dateTimeBetween('-3 years', 'now');

        return [
            'person_id' => Person::factory(),
            'stufe' => $this->faker->numberBetween(1, 3),
            'zugestimmt_am' => Carbon::parse($zugestimmt)->format('d.m.Y'),
            'widerrufen_am' => null,
            'bemerkungen' => $this->faker->optional(0.2)->sentence(),
            'ist_aktiv' => true,
        ];
    }

    /**
     * Indicate that the DSGVO declaration has been revoked.
     */
    public function widerrufen(): static
    {
        return $this->state(function (array $attributes) {
            $zugestimmt = Carbon::createFromFormat('d.m.Y', $attributes['zugestimmt_am']);
            $widerrufen = $this->faker->dateTimeBetween($zugestimmt, 'now');

            return [
                'widerrufen_am' => Carbon::parse($widerrufen)->format('d.m.Y'),
                'ist_aktiv' => false,
            ];
        });
    }

    /**
     * Indicate a specific DSGVO level (Stufe).
     */
    public function stufe(int $stufe): static
    {
        return $this->state(fn (array $attributes) => [
            'stufe' => $stufe,
        ]);
    }

    /**
     * Indicate a recent declaration (within last month).
     */
    public function recent(): static
    {
        return $this->state(fn (array $attributes) => [
            'zugestimmt_am' => Carbon::now()->subDays($this->faker->numberBetween(1, 30))->format('d.m.Y'),
        ]);
    }

    /**
     * Indicate an old declaration (2+ years ago).
     */
    public function old(): static
    {
        return $this->state(fn (array $attributes) => [
            'zugestimmt_am' => Carbon::now()->subYears($this->faker->numberBetween(2, 5))->format('d.m.Y'),
        ]);
    }
}
