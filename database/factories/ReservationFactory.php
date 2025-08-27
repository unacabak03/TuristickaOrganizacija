<?php

namespace Database\Factories;

use App\Models\Reservation;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Reservation::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => $this->faker->randomElement(['placed','confirmed','canceled']),
            'number_of_people' => fake()->randomNumber(0),
            'user_id' => \App\Models\User::factory(),
            'tour_id' => \App\Models\Tour::factory(),
        ];
    }
}
